<?php

namespace Tests\Feature;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserAccountPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_profile_details_page(): void
    {
        $user = User::factory()->create();
        /** @var Profile $profile */
        $profile = $user->profiles()->create([
            'title' => 'Field profile',
            'name' => 'Field User',
            'email' => 'field@example.com',
            'phone' => '+70000000041',
            'address' => 'Field address',
            'comment' => 'Ring before delivery',
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('user.profile.show', ['profile' => $profile]));

        $response->assertOk()
            ->assertSeeText('Field profile')
            ->assertSeeText('Field User')
            ->assertSeeText('Ring before delivery');
    }

    public function test_authenticated_user_can_view_order_details_page_with_payment_status(): void
    {
        $user = User::factory()->create();
        $order = new Order([
            'name' => 'Order Owner',
            'email' => 'owner@example.com',
            'phone' => '+70000000042',
            'address' => 'Owner address',
            'comment' => 'Handle with care',
            'currency' => 'KZT',
            'payment_method' => 'online_card',
            'status' => OrderStatus::Paid->value,
        ]);
        $order->user()->associate($user);
        $order->amount = '3300.00';
        $order->save();

        $order->items()->create([
            'product_id' => null,
            'name' => 'Field Lamp',
            'price' => '3300.00',
            'quantity' => 1,
            'cost' => '3300.00',
        ]);

        // The page renders payment summary from the related payment record, not only from the order itself.
        Payment::query()->create([
            'order_id' => $order->id,
            'provider' => 'fake',
            'status' => 'succeeded',
            'amount' => '3300.00',
            'currency' => 'KZT',
            'store_amount' => '3300.00',
            'store_currency' => 'KZT',
            'conversion_rate' => '1.000000',
            'checkout_flow' => 'hosted_fields',
            'provider_payment_id' => 'fake-order-page-1',
            'paid_at' => now(),
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('user.order.show', ['order' => $order]));

        $response->assertOk()
            ->assertSeeText('Field Lamp')
            ->assertSeeText('Order Owner')
            ->assertSeeText(__('site.payments.status'));
    }
}
