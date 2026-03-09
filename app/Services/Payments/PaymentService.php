<?php

namespace App\Services\Payments;

use App\DTO\Payments\PaymentCreationResult;
use App\DTO\Payments\PaymentResolutionResult;
use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Throwable;

class PaymentService
{
    public function __construct(private readonly PaymentManager $manager)
    {
    }

    public function createForOrder(Order $order, ?string $providerCode = null): Payment
    {
        $providerCode ??= (string) config('payments.default');
        $storeCurrency = (string) ($order->currency ?: config('payments.store_currency', 'KZT'));
        $providerCurrency = $this->providerCurrency($providerCode, $storeCurrency);
        $conversionRate = $this->conversionRate($providerCode, $storeCurrency, $providerCurrency);

        $payment = Payment::create([
            'order_id' => $order->id,
            'provider' => $providerCode,
            'status' => PaymentStatus::Created->value,
            'amount' => $this->convertAmount((float) $order->amount, $storeCurrency, $providerCurrency, $conversionRate),
            'currency' => $providerCurrency,
            'store_amount' => $order->amount,
            'store_currency' => $storeCurrency,
            'conversion_rate' => $conversionRate,
            'checkout_flow' => $this->checkoutFlow($providerCode),
        ]);

        try {
            $result = $this->manager->driver($payment->provider)->createPayment($payment, $order);
        } catch (Throwable $exception) {
            $payment->forceFill([
                'status' => PaymentStatus::Failed->value,
                'failure_reason' => $exception->getMessage(),
                'failed_at' => now(),
            ])->save();

            throw $exception;
        }

        return $this->applyCreationResult($payment, $result);
    }

    public function finalize(Payment $payment, array $parameters = []): Payment
    {
        if ($payment->statusEnum() === PaymentStatus::Succeeded) {
            return $payment->fresh(['order']);
        }

        try {
            $result = $this->manager->driver($payment->provider)->finalizePayment($payment, $parameters);
        } catch (Throwable $exception) {
            $payment->forceFill([
                'status' => PaymentStatus::Failed->value,
                'failure_reason' => $exception->getMessage(),
                'failed_at' => now(),
            ])->save();

            throw $exception;
        }

        return $this->applyResolutionResult($payment, $result);
    }

    public function markCancelled(Payment $payment, ?string $reason = null): Payment
    {
        return $this->applyResolutionResult($payment, new PaymentResolutionResult(
            PaymentStatus::Cancelled,
            providerPaymentId: $payment->provider_payment_id,
            failureReason: $reason,
        ));
    }

    public function handleWebhook(string $providerCode, array $headers, array $payload): Payment
    {
        $driver = $this->manager->driver($providerCode);

        if (! $driver->verifyWebhook($headers, $payload)) {
            abort(422, 'Webhook signature verification failed.');
        }

        $result = $driver->resolveWebhook($payload);
        $providerPaymentId = $result->providerPaymentId;

        abort_if($providerPaymentId === null, 422, 'Webhook payload is missing provider payment id.');

        /** @var Payment $payment */
        $payment = Payment::query()
            ->where('provider', $providerCode)
            ->where('provider_payment_id', $providerPaymentId)
            ->firstOrFail();

        return $this->applyResolutionResult($payment, $result, $payload);
    }

    public function checkoutConfiguration(Payment $payment): array
    {
        return $this->manager->driver($payment->provider)->checkoutConfiguration($payment);
    }

    public function statusPageUrl(Payment $payment): string
    {
        return rtrim((string) config('payments.status_page_base_url'), '/').'/'.$payment->public_id;
    }

    private function applyCreationResult(Payment $payment, PaymentCreationResult $result): Payment
    {
        $payment->forceFill([
            'status' => $result->status->value,
            'provider_payment_id' => $result->providerPaymentId,
            'redirect_url' => $result->redirectUrl,
            'failure_reason' => $result->failureReason,
            'raw_create_payload' => $result->requestPayload,
            'raw_create_response' => $result->responsePayload,
            'failed_at' => $result->status === PaymentStatus::Failed ? now() : null,
        ])->save();

        return $payment->fresh(['order']);
    }

    private function applyResolutionResult(
        Payment $payment,
        PaymentResolutionResult $result,
        array $webhookPayload = [],
    ): Payment {
        return DB::transaction(function () use ($payment, $result, $webhookPayload) {
            $currentStatus = $payment->statusEnum();
            $resolvedStatus = $this->resolveNextStatus($currentStatus, $result->status);

            $payment->forceFill([
                'status' => $resolvedStatus->value,
                'provider_payment_id' => $result->providerPaymentId ?? $payment->provider_payment_id,
                'provider_operation_id' => $result->providerOperationId ?? $payment->provider_operation_id,
                'failure_reason' => $result->failureReason,
                'paid_at' => $resolvedStatus === PaymentStatus::Succeeded ? ($payment->paid_at ?? now()) : $payment->paid_at,
                'failed_at' => $resolvedStatus === PaymentStatus::Failed ? now() : $payment->failed_at,
                'cancelled_at' => $resolvedStatus === PaymentStatus::Cancelled ? now() : $payment->cancelled_at,
                'last_webhook_at' => $webhookPayload !== [] ? now() : $payment->last_webhook_at,
                'raw_webhook_payload' => $webhookPayload !== [] ? $webhookPayload : $payment->raw_webhook_payload,
            ])->save();

            if ($resolvedStatus === PaymentStatus::Succeeded && $payment->order->statusEnum() !== OrderStatus::Paid) {
                $payment->order->forceFill([
                    'status' => OrderStatus::Paid->value,
                ])->save();
            }

            return $payment->fresh(['order']);
        });
    }

    private function resolveNextStatus(PaymentStatus $current, PaymentStatus $incoming): PaymentStatus
    {
        if ($current === PaymentStatus::Succeeded) {
            return PaymentStatus::Succeeded;
        }

        return $incoming;
    }

    private function providerCurrency(string $providerCode, string $storeCurrency): string
    {
        return (string) config("payments.providers.{$providerCode}.currency", $storeCurrency);
    }

    private function conversionRate(string $providerCode, string $storeCurrency, string $providerCurrency): float
    {
        if ($providerCurrency === $storeCurrency) {
            return 1.0;
        }

        $rate = (float) config("payments.providers.{$providerCode}.exchange_rate", 0);

        if ($rate <= 0) {
            throw new \RuntimeException("Payment exchange rate is not configured for provider [{$providerCode}].");
        }

        return $rate;
    }

    private function convertAmount(float $storeAmount, string $storeCurrency, string $providerCurrency, float $conversionRate): float
    {
        if ($providerCurrency === $storeCurrency) {
            return round($storeAmount, 2);
        }

        return round($storeAmount / $conversionRate, 2);
    }

    private function checkoutFlow(string $providerCode): string
    {
        return (string) config("payments.providers.{$providerCode}.checkout_flow", 'redirect');
    }
}
