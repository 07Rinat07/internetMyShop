<?php

namespace App\Services\Payments\Providers;

use App\Contracts\Payments\PaymentProviderDriver;
use App\DTO\Payments\PaymentCreationResult;
use App\DTO\Payments\PaymentResolutionResult;
use App\Enums\PaymentProvider;
use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class PayPalProvider implements PaymentProviderDriver
{
    public function code(): string
    {
        return PaymentProvider::PayPal->value;
    }

    public function createPayment(Payment $payment, Order $order): PaymentCreationResult
    {
        $requestPayload = [
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'reference_id' => (string) $order->id,
                    'custom_id' => $payment->public_id,
                    'description' => 'internetMyShop order #'.$order->id,
                    'amount' => [
                        'currency_code' => (string) $payment->currency,
                        'value' => $this->formatAmount($payment->amount),
                    ],
                ],
            ],
        ];

        $response = $this->authorizedRequest()
            ->withHeaders([
                'PayPal-Request-Id' => 'create-'.$payment->public_id,
            ])
            ->post('/v2/checkout/orders', $requestPayload);

        if ($response->failed()) {
            throw new RuntimeException('Failed to create PayPal order.');
        }

        $responsePayload = $response->json();

        return new PaymentCreationResult(
            status: PaymentStatus::Pending,
            providerPaymentId: (string) ($responsePayload['id'] ?? ''),
            requestPayload: $requestPayload,
            responsePayload: is_array($responsePayload) ? $responsePayload : [],
        );
    }

    public function finalizePayment(Payment $payment, array $parameters = []): PaymentResolutionResult
    {
        $providerPaymentId = (string) ($parameters['token'] ?? $parameters['provider_payment_id'] ?? $payment->provider_payment_id ?? '');

        if ($providerPaymentId === '') {
            throw new RuntimeException('Missing PayPal order token.');
        }

        if ($payment->provider_payment_id && $providerPaymentId !== $payment->provider_payment_id) {
            throw new RuntimeException('PayPal order token mismatch.');
        }

        $response = $this->authorizedRequest()
            ->withHeaders([
                'PayPal-Request-Id' => 'capture-'.$payment->public_id,
            ])
            ->post("/v2/checkout/orders/{$providerPaymentId}/capture");

        if ($response->failed()) {
            throw new RuntimeException('Failed to capture PayPal order.');
        }

        $payload = $response->json();
        $status = $this->mapOrderStatus((string) ($payload['status'] ?? ''));
        $providerOperationId = Arr::get($payload, 'purchase_units.0.payments.captures.0.id');

        return new PaymentResolutionResult(
            status: $status,
            providerPaymentId: $providerPaymentId,
            providerOperationId: is_string($providerOperationId) ? $providerOperationId : null,
            payload: is_array($payload) ? $payload : [],
        );
    }

    public function checkoutConfiguration(Payment $payment): array
    {
        $clientId = (string) config('payments.providers.paypal.client_id');

        if ($clientId === '') {
            throw new RuntimeException((string) __('site.messages.paypal_client_id_missing'));
        }

        return [
            'flow' => 'hosted_fields',
            'provider_payment_id' => $payment->provider_payment_id,
            'capture_url' => route('api.v1.payments.capture', ['payment' => $payment]),
            'status_url' => route('payments.status', ['payment' => $payment]),
            'sdk' => [
                'namespace' => 'paypal',
                'client_id' => $clientId,
                'client_token' => $this->clientToken(),
                'currency' => $payment->currency,
                'intent' => 'capture',
                'components' => ['buttons', 'card-fields'],
                'merchant_id' => (string) config('payments.providers.paypal.merchant_id'),
                'script_url' => $this->sdkUrl($payment),
            ],
        ];
    }

    public function verifyWebhook(array $headers, array $payload): bool
    {
        $webhookId = (string) config('payments.providers.paypal.webhook_id');

        if ($webhookId === '') {
            return false;
        }

        $response = $this->authorizedRequest()->post('/v1/notifications/verify-webhook-signature', [
            'transmission_id' => $headers['paypal-transmission-id'] ?? null,
            'transmission_time' => $headers['paypal-transmission-time'] ?? null,
            'cert_url' => $headers['paypal-cert-url'] ?? null,
            'auth_algo' => $headers['paypal-auth-algo'] ?? null,
            'transmission_sig' => $headers['paypal-transmission-sig'] ?? null,
            'webhook_id' => $webhookId,
            'webhook_event' => $payload,
        ]);

        if ($response->failed()) {
            return false;
        }

        return $response->json('verification_status') === 'SUCCESS';
    }

    public function resolveWebhook(array $payload): PaymentResolutionResult
    {
        $eventType = (string) ($payload['event_type'] ?? '');
        $resource = is_array($payload['resource'] ?? null) ? $payload['resource'] : [];
        $providerPaymentId = Arr::get($resource, 'supplementary_data.related_ids.order_id')
            ?? (str_starts_with($eventType, 'CHECKOUT.ORDER') ? ($resource['id'] ?? null) : null);
        $providerOperationId = $resource['id'] ?? null;

        return new PaymentResolutionResult(
            status: $this->mapWebhookStatus($eventType),
            providerPaymentId: is_string($providerPaymentId) ? $providerPaymentId : null,
            providerOperationId: is_string($providerOperationId) ? $providerOperationId : null,
            failureReason: $this->failureReasonForEvent($eventType),
            payload: $payload,
        );
    }

    private function authorizedRequest()
    {
        return Http::baseUrl($this->baseUrl())
            ->acceptJson()
            ->withToken($this->accessToken());
    }

    private function accessToken(): string
    {
        $clientId = (string) config('payments.providers.paypal.client_id');
        $clientSecret = (string) config('payments.providers.paypal.client_secret');

        if ($clientId === '' || $clientSecret === '') {
            throw new RuntimeException((string) __('site.messages.paypal_credentials_missing'));
        }

        $response = Http::baseUrl($this->baseUrl())
            ->acceptJson()
            ->asForm()
            ->withBasicAuth($clientId, $clientSecret)
            ->post('/v1/oauth2/token', [
                'grant_type' => 'client_credentials',
            ]);

        if ($response->failed()) {
            throw new RuntimeException('Failed to obtain PayPal access token.');
        }

        $token = (string) $response->json('access_token');

        if ($token === '') {
            throw new RuntimeException('PayPal access token is missing in the response.');
        }

        return $token;
    }

    private function baseUrl(): string
    {
        return rtrim((string) config('payments.providers.paypal.base_url'), '/');
    }

    private function clientToken(): string
    {
        $response = $this->authorizedRequest()
            ->post('/v1/identity/generate-token');

        if ($response->failed()) {
            throw new RuntimeException('Failed to obtain PayPal client token.');
        }

        $clientToken = (string) $response->json('client_token');

        if ($clientToken === '') {
            throw new RuntimeException('PayPal client token is missing in the response.');
        }

        return $clientToken;
    }

    private function mapOrderStatus(string $status): PaymentStatus
    {
        return match ($status) {
            'COMPLETED' => PaymentStatus::Succeeded,
            'PAYER_ACTION_REQUIRED' => PaymentStatus::RequiresAction,
            'APPROVED', 'CREATED', 'SAVED' => PaymentStatus::Pending,
            default => PaymentStatus::Failed,
        };
    }

    private function mapWebhookStatus(string $eventType): PaymentStatus
    {
        return match ($eventType) {
            'PAYMENT.CAPTURE.COMPLETED' => PaymentStatus::Succeeded,
            'PAYMENT.CAPTURE.PENDING', 'CHECKOUT.ORDER.APPROVED' => PaymentStatus::Pending,
            'PAYMENT.CAPTURE.DENIED', 'PAYMENT.CAPTURE.DECLINED' => PaymentStatus::Failed,
            'CHECKOUT.ORDER.VOIDED' => PaymentStatus::Cancelled,
            default => PaymentStatus::Pending,
        };
    }

    private function failureReasonForEvent(string $eventType): ?string
    {
        return match ($eventType) {
            'PAYMENT.CAPTURE.DENIED', 'PAYMENT.CAPTURE.DECLINED' => $eventType,
            'CHECKOUT.ORDER.VOIDED' => $eventType,
            default => null,
        };
    }

    private function formatAmount(mixed $amount): string
    {
        return number_format((float) $amount, 2, '.', '');
    }

    private function sdkUrl(Payment $payment): string
    {
        $query = [
            'client-id' => (string) config('payments.providers.paypal.client_id'),
            'components' => 'buttons,card-fields',
            'currency' => $payment->currency,
            'intent' => 'capture',
        ];

        $merchantId = (string) config('payments.providers.paypal.merchant_id');

        if ($merchantId !== '') {
            $query['merchant-id'] = $merchantId;
        }

        return 'https://www.paypal.com/sdk/js?'.http_build_query($query);
    }
}
