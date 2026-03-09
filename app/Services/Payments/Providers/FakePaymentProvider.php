<?php

namespace App\Services\Payments\Providers;

use App\Contracts\Payments\PaymentProviderDriver;
use App\DTO\Payments\PaymentCreationResult;
use App\DTO\Payments\PaymentResolutionResult;
use App\Enums\PaymentProvider;
use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\Payment;
use RuntimeException;

class FakePaymentProvider implements PaymentProviderDriver
{
    public function code(): string
    {
        return PaymentProvider::Fake->value;
    }

    public function createPayment(Payment $payment, Order $order): PaymentCreationResult
    {
        $providerPaymentId = 'fake-'.$payment->public_id;

        return new PaymentCreationResult(
            status: PaymentStatus::Pending,
            providerPaymentId: $providerPaymentId,
            requestPayload: [
                'order_id' => $order->id,
                'payment_id' => $payment->public_id,
            ],
            responsePayload: [
                'provider_payment_id' => $providerPaymentId,
            ],
        );
    }

    public function finalizePayment(Payment $payment, array $parameters = []): PaymentResolutionResult
    {
        $token = (string) ($parameters['token'] ?? $parameters['provider_payment_id'] ?? '');

        if ($token === '' || $token !== $payment->provider_payment_id) {
            throw new RuntimeException('Fake payment token mismatch.');
        }

        return new PaymentResolutionResult(
            status: PaymentStatus::Succeeded,
            providerPaymentId: $payment->provider_payment_id,
            providerOperationId: 'fake-capture-'.$payment->public_id,
            payload: [
                'token' => $token,
            ],
        );
    }

    public function checkoutConfiguration(Payment $payment): array
    {
        return [
            'flow' => 'hosted_fields',
            'provider_payment_id' => $payment->provider_payment_id,
            'capture_url' => route('api.v1.payments.capture', ['payment' => $payment]),
            'status_url' => route('payments.status', ['payment' => $payment]),
            'sandbox_card' => [
                'number' => '4111111111111111',
                'expiry' => '12/2030',
                'cvv' => '123',
                'postal_code' => '75001',
            ],
        ];
    }

    public function verifyWebhook(array $headers, array $payload): bool
    {
        return true;
    }

    public function resolveWebhook(array $payload): PaymentResolutionResult
    {
        $providerPaymentId = (string) ($payload['provider_payment_id'] ?? '');

        return new PaymentResolutionResult(
            status: PaymentStatus::from((string) ($payload['status'] ?? PaymentStatus::Pending->value)),
            providerPaymentId: $providerPaymentId !== '' ? $providerPaymentId : null,
            providerOperationId: (string) ($payload['provider_operation_id'] ?? ''),
            payload: $payload,
        );
    }
}
