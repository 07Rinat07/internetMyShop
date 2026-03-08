<?php

namespace Tests\Feature\Admin;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminOrderManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admin_cannot_update_order_status(): void
    {
        $user = User::factory()->create();
        $order = $this->createOrder();

        $response = $this
            ->actingAs($user)
            ->put(route('admin.order.update', ['order' => $order->id]), [
                'status' => OrderStatus::Processed->value,
            ]);

        $response->assertForbidden();
    }

    public function test_admin_updates_only_order_status(): void
    {
        $admin = User::factory()->create(['admin' => true]);
        $owner = User::factory()->create();
        $order = $this->createOrder($owner);

        $response = $this
            ->actingAs($admin)
            ->put(route('admin.order.update', ['order' => $order->id]), [
                'status' => OrderStatus::Processed->value,
                'amount' => 1,
                'user_id' => $admin->id,
            ]);

        $response->assertRedirect(route('admin.order.show', ['order' => $order->id]));

        $order->refresh();

        $this->assertSame(OrderStatus::Processed->value, (int) $order->status);
        $this->assertSame(500.0, (float) $order->amount);
        $this->assertSame($owner->id, $order->user_id);
    }

    private function createOrder(?User $owner = null): Order
    {
        $owner ??= User::factory()->create();

        $order = new Order([
            'name' => 'Admin test order',
            'email' => 'admin-order@example.test',
            'phone' => '+70000000033',
            'address' => 'Admin street',
            'comment' => 'Admin comment',
            'status' => OrderStatus::New->value,
        ]);

        $order->user()->associate($owner);
        $order->amount = 500;
        $order->save();

        return $order;
    }
}
