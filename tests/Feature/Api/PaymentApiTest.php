<?php

namespace Tests\Feature\Api;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PaymentApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_payment_endpoint_returns_payment_status_and_order_summary(): void
    {
        [$order, $payment] = $this->createOrderWithPayment();

        $response = $this->getJson('/api/v1/payments/'.$payment->public_id);

        $response->assertOk()
            ->assertJsonPath('data.id', $payment->public_id)
            ->assertJsonPath('data.status.code', PaymentStatus::Pending->value)
            ->assertJsonPath('data.order.id', $order->id)
            ->assertJsonPath('data.order.status.code', OrderStatus::New->value)
            ->assertJsonPath('data.order.payment_method.code', 'online_card')
            ->assertJsonPath('data.store_amount', 2500)
            ->assertJsonPath('data.store_currency', 'KZT');
    }

    public function test_public_payment_endpoint_accepts_internal_docker_host(): void
    {
        [, $payment] = $this->createOrderWithPayment();

        $response = $this
            ->withServerVariables(['HTTP_HOST' => 'app'])
            ->getJson('/api/v1/payments/'.$payment->public_id);

        $response->assertOk()
            ->assertJsonPath('data.id', $payment->public_id);
    }

    public function test_public_payment_endpoint_uses_locale_header_for_translated_labels(): void
    {
        [, $payment] = $this->createOrderWithPayment();

        $response = $this
            ->withHeaders(['X-Locale' => 'en'])
            ->getJson('/api/v1/payments/'.$payment->public_id);

        $response->assertOk()
            ->assertJsonPath('data.status.label', 'Pending confirmation')
            ->assertJsonPath('data.order.payment_method.label', 'Online card');
    }

    public function test_paypal_return_route_captures_payment_and_marks_order_paid(): void
    {
        config()->set('payments.status_page_base_url', 'http://localhost:3000/payments');
        config()->set('payments.providers.paypal.client_id', 'sandbox-client');
        config()->set('payments.providers.paypal.client_secret', 'sandbox-secret');
        config()->set('payments.providers.paypal.base_url', 'https://api-m.sandbox.paypal.com');

        Http::fake(function ($request) {
            $url = $request->url();

            if (str_ends_with($url, '/v1/oauth2/token')) {
                return Http::response([
                    'access_token' => 'sandbox-access-token',
                ]);
            }

            if (str_ends_with($url, '/v2/checkout/orders/PAYPAL-ORDER-1/capture')) {
                return Http::response([
                    'id' => 'PAYPAL-ORDER-1',
                    'status' => 'COMPLETED',
                    'purchase_units' => [
                        [
                            'payments' => [
                                'captures' => [
                                    ['id' => 'CAPTURE-1'],
                                ],
                            ],
                        ],
                    ],
                ], 201);
            }

            return Http::response([], 500);
        });

        [$order, $payment] = $this->createOrderWithPayment([
            'provider_payment_id' => 'PAYPAL-ORDER-1',
        ]);

        $response = $this->get(route('payments.providers.return', [
            'provider' => 'paypal',
            'payment' => $payment,
        ]).'?token=PAYPAL-ORDER-1&PayerID=BUYER-1');

        $response->assertRedirect('http://localhost:3000/payments/'.$payment->public_id);

        $this->assertSame(PaymentStatus::Succeeded->value, $payment->fresh()->status);
        $this->assertSame('CAPTURE-1', $payment->fresh()->provider_operation_id);
        $this->assertSame(OrderStatus::Paid->value, $order->fresh()->status);
    }

    public function test_paypal_webhook_marks_payment_paid_after_signature_verification(): void
    {
        config()->set('payments.providers.paypal.client_id', 'sandbox-client');
        config()->set('payments.providers.paypal.client_secret', 'sandbox-secret');
        config()->set('payments.providers.paypal.base_url', 'https://api-m.sandbox.paypal.com');
        config()->set('payments.providers.paypal.webhook_id', 'WH-TEST-1');

        Http::fake(function ($request) {
            $url = $request->url();

            if (str_ends_with($url, '/v1/oauth2/token')) {
                return Http::response([
                    'access_token' => 'sandbox-access-token',
                ]);
            }

            if (str_ends_with($url, '/v1/notifications/verify-webhook-signature')) {
                return Http::response([
                    'verification_status' => 'SUCCESS',
                ]);
            }

            return Http::response([], 500);
        });

        [$order, $payment] = $this->createOrderWithPayment([
            'provider_payment_id' => 'PAYPAL-ORDER-1',
        ]);

        $response = $this->withHeaders([
            'PayPal-Transmission-Id' => 'transmission-id',
            'PayPal-Transmission-Time' => '2026-03-09T01:00:00Z',
            'PayPal-Cert-Url' => 'https://api-m.paypal.com/certs/cert.pem',
            'PayPal-Auth-Algo' => 'SHA256withRSA',
            'PayPal-Transmission-Sig' => 'signature',
        ])->postJson('/api/v1/payments/webhook/paypal', [
            'event_type' => 'PAYMENT.CAPTURE.COMPLETED',
            'resource' => [
                'id' => 'CAPTURE-1',
                'supplementary_data' => [
                    'related_ids' => [
                        'order_id' => 'PAYPAL-ORDER-1',
                    ],
                ],
            ],
        ]);

        $response->assertOk()
            ->assertJsonPath('data.payment_id', $payment->public_id)
            ->assertJsonPath('data.status', PaymentStatus::Succeeded->value);

        $this->assertSame(PaymentStatus::Succeeded->value, $payment->fresh()->status);
        $this->assertSame(OrderStatus::Paid->value, $order->fresh()->status);
    }

    public function test_paypal_webhook_rejects_invalid_signature(): void
    {
        config()->set('payments.providers.paypal.client_id', 'sandbox-client');
        config()->set('payments.providers.paypal.client_secret', 'sandbox-secret');
        config()->set('payments.providers.paypal.base_url', 'https://api-m.sandbox.paypal.com');
        config()->set('payments.providers.paypal.webhook_id', 'WH-TEST-1');

        Http::fake(function ($request) {
            $url = $request->url();

            if (str_ends_with($url, '/v1/oauth2/token')) {
                return Http::response([
                    'access_token' => 'sandbox-access-token',
                ]);
            }

            if (str_ends_with($url, '/v1/notifications/verify-webhook-signature')) {
                return Http::response([
                    'verification_status' => 'FAILURE',
                ]);
            }

            return Http::response([], 500);
        });

        [, $payment] = $this->createOrderWithPayment([
            'provider_payment_id' => 'PAYPAL-ORDER-1',
        ]);

        $response = $this->withHeaders([
            'PayPal-Transmission-Id' => 'transmission-id',
            'PayPal-Transmission-Time' => '2026-03-09T01:00:00Z',
            'PayPal-Cert-Url' => 'https://api-m.paypal.com/certs/cert.pem',
            'PayPal-Auth-Algo' => 'SHA256withRSA',
            'PayPal-Transmission-Sig' => 'signature',
        ])->postJson('/api/v1/payments/webhook/paypal', [
            'event_type' => 'PAYMENT.CAPTURE.COMPLETED',
            'resource' => [
                'id' => 'CAPTURE-1',
                'supplementary_data' => [
                    'related_ids' => [
                        'order_id' => 'PAYPAL-ORDER-1',
                    ],
                ],
            ],
        ]);

        $response->assertStatus(422);
        $this->assertSame(PaymentStatus::Pending->value, $payment->fresh()->status);
    }

    public function test_checkout_config_endpoint_returns_paypal_hosted_fields_config(): void
    {
        config()->set('payments.status_page_base_url', 'http://localhost:3000/payments');
        config()->set('payments.providers.paypal.client_id', 'sandbox-client');
        config()->set('payments.providers.paypal.client_secret', 'sandbox-secret');
        config()->set('payments.providers.paypal.base_url', 'https://api-m.sandbox.paypal.com');

        Http::fake(function ($request) {
            $url = $request->url();

            if (str_ends_with($url, '/v1/oauth2/token')) {
                return Http::response([
                    'access_token' => 'sandbox-access-token',
                ]);
            }

            if (str_ends_with($url, '/v1/identity/generate-token')) {
                return Http::response([
                    'client_token' => 'sandbox-client-token',
                ]);
            }

            return Http::response([], 500);
        });

        [, $payment] = $this->createOrderWithPayment();

        $response = $this->getJson('/api/v1/payments/'.$payment->public_id.'/checkout-config');

        $response->assertOk()
            ->assertJsonPath('data.flow', 'hosted_fields')
            ->assertJsonPath('data.payment_id', $payment->public_id)
            ->assertJsonPath('data.provider_payment_id', $payment->provider_payment_id)
            ->assertJsonPath('data.status_url', 'http://localhost:3000/payments/'.$payment->public_id)
            ->assertJsonPath('data.sdk.namespace', 'paypal')
            ->assertJsonPath('data.sdk.client_token', 'sandbox-client-token')
            ->assertJsonPath('data.sdk.currency', 'USD');
    }

    public function test_capture_endpoint_marks_fake_payment_paid(): void
    {
        [$order, $payment] = $this->createOrderWithPayment([
            'provider' => 'fake',
            'provider_payment_id' => 'fake-payment-1',
            'currency' => 'KZT',
            'amount' => 2500,
            'store_amount' => 2500,
            'store_currency' => 'KZT',
            'conversion_rate' => 1,
            'checkout_flow' => 'hosted_fields',
        ]);

        $response = $this->postJson('/api/v1/payments/'.$payment->public_id.'/capture', [
            'provider_payment_id' => 'fake-payment-1',
        ]);

        $response->assertOk()
            ->assertJsonPath('data.status.code', PaymentStatus::Succeeded->value);

        $this->assertSame(PaymentStatus::Succeeded->value, $payment->fresh()->status);
        $this->assertSame(OrderStatus::Paid->value, $order->fresh()->status);
    }

    public function test_capture_endpoint_returns_422_when_provider_rejects_capture(): void
    {
        [, $payment] = $this->createOrderWithPayment([
            'provider' => 'fake',
            'provider_payment_id' => 'fake-payment-2',
            'currency' => 'KZT',
            'amount' => '2500.00',
            'store_amount' => '2500.00',
            'store_currency' => 'KZT',
            'conversion_rate' => '1.000000',
            'checkout_flow' => 'hosted_fields',
        ]);

        $response = $this->postJson('/api/v1/payments/'.$payment->public_id.'/capture', [
            'provider_payment_id' => 'wrong-token',
        ]);

        $response->assertStatus(422)
            ->assertJsonPath('message', 'Failed to capture payment.')
            ->assertJsonValidationErrors(['payment']);

        $this->assertSame(PaymentStatus::Failed->value, $payment->fresh()->status);
    }

    private function createOrderWithPayment(array $paymentOverrides = []): array
    {
        $order = new Order([
            'name' => 'Payment customer',
            'email' => 'payment@example.com',
            'phone' => '+70000000000',
            'address' => 'Payment street',
            'comment' => 'Payment comment',
            'currency' => 'KZT',
            'payment_method' => 'online_card',
        ]);
        $order->amount = 2500;
        $order->status = OrderStatus::New->value;
        $order->save();

        $payment = Payment::query()->create(array_merge([
            'order_id' => $order->id,
            'provider' => 'paypal',
            'status' => PaymentStatus::Pending->value,
            'amount' => 5,
            'currency' => 'USD',
            'store_amount' => 2500,
            'store_currency' => 'KZT',
            'conversion_rate' => 500,
            'checkout_flow' => 'hosted_fields',
            'provider_payment_id' => 'PAYPAL-ORDER-1',
        ], $paymentOverrides));

        return [$order, $payment];
    }
}
