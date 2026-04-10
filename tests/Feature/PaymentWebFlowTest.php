<?php

namespace Tests\Feature;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentWebFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_payment_status_page_renders_order_summary(): void
    {
        [$order, $payment] = $this->createOrderWithPayment([
            'status' => PaymentStatus::Pending->value,
            'failure_reason' => 'Awaiting capture',
        ]);

        $response = $this->get(route('payments.status', ['payment' => $payment]));

        $response->assertOk()
            ->assertSeeText($payment->public_id)
            ->assertSeeText($payment->failure_reason)
            ->assertSeeText(__('site.account.order_details', ['id' => $order->id]))
            ->assertSeeText('Trail Stove');
    }

    public function test_provider_return_route_finalizes_fake_payment_and_redirects_to_status_page(): void
    {
        config()->set('payments.status_page_base_url', url('/payments'));

        [$order, $payment] = $this->createOrderWithPayment([
            'provider' => 'fake',
            'status' => PaymentStatus::Pending->value,
            'provider_payment_id' => 'fake-payment-return',
        ]);

        // Fake provider treats the `token` query string as the provider payment id during finalize.
        $response = $this->get(route('payments.providers.return', [
            'provider' => 'fake',
            'payment' => $payment,
        ]).'?token=fake-payment-return');

        $response->assertRedirect(route('payments.status', ['payment' => $payment]));
        $this->assertSame(PaymentStatus::Succeeded->value, $payment->fresh()->status);
        $this->assertSame(OrderStatus::Paid->value, $order->fresh()->status);
    }

    public function test_provider_cancel_route_marks_pending_payment_cancelled(): void
    {
        config()->set('payments.status_page_base_url', url('/payments'));

        [, $payment] = $this->createOrderWithPayment([
            'status' => PaymentStatus::Pending->value,
        ]);

        $response = $this->get(route('payments.providers.cancel', [
            'provider' => 'paypal',
            'payment' => $payment,
        ]));

        $response->assertRedirect(route('payments.status', ['payment' => $payment]));
        $this->assertSame(PaymentStatus::Cancelled->value, $payment->fresh()->status);
        $this->assertSame('Payment was cancelled by the user.', $payment->fresh()->failure_reason);
    }

    public function test_provider_cancel_route_does_not_downgrade_successful_payment(): void
    {
        config()->set('payments.status_page_base_url', url('/payments'));

        [, $payment] = $this->createOrderWithPayment([
            'status' => PaymentStatus::Succeeded->value,
            'paid_at' => now(),
        ]);

        $response = $this->get(route('payments.providers.cancel', [
            'provider' => 'paypal',
            'payment' => $payment,
        ]));

        $response->assertRedirect(route('payments.status', ['payment' => $payment]));
        $this->assertSame(PaymentStatus::Succeeded->value, $payment->fresh()->status);
    }

    public function test_provider_routes_return_404_for_provider_mismatch(): void
    {
        [, $payment] = $this->createOrderWithPayment([
            'provider' => 'paypal',
        ]);

        $this->get(route('payments.providers.return', [
            'provider' => 'fake',
            'payment' => $payment,
        ]))->assertNotFound();

        $this->get(route('payments.providers.cancel', [
            'provider' => 'fake',
            'payment' => $payment,
        ]))->assertNotFound();
    }

    /**
     * @return array{0: Order, 1: Payment}
     */
    private function createOrderWithPayment(array $paymentOverrides = []): array
    {
        $order = new Order([
            'name' => 'Web payment customer',
            'email' => 'web-payment@example.com',
            'phone' => '+70000000031',
            'address' => 'Payment web street',
            'comment' => 'Payment web comment',
            'currency' => 'KZT',
            'payment_method' => 'online_card',
        ]);
        $order->amount = '2500.00';
        $order->status = OrderStatus::New->value;
        $order->save();

        $order->items()->create([
            'product_id' => null,
            'name' => 'Trail Stove',
            'price' => '2500.00',
            'quantity' => 1,
            'cost' => '2500.00',
        ]);

        $payment = Payment::query()->create(array_merge([
            'order_id' => $order->id,
            'provider' => 'paypal',
            'status' => PaymentStatus::Pending->value,
            'amount' => '5.00',
            'currency' => 'USD',
            'store_amount' => '2500.00',
            'store_currency' => 'KZT',
            'conversion_rate' => '500.000000',
            'checkout_flow' => 'hosted_fields',
            'provider_payment_id' => 'PAYPAL-WEB-ORDER-1',
        ], $paymentOverrides));

        return [$order, $payment];
    }
}
