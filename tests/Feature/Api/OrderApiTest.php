<?php

namespace Tests\Feature\Api;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderApiTest extends TestCase {
    use RefreshDatabase;

    public function test_index_returns_only_authenticated_users_orders() {
        $user = factory(User::class)->create();
        $otherUser = factory(User::class)->create();

        $ownOrder = $this->createOrderForUser($user, 'own@example.com');
        $this->createOrderForUser($otherUser, 'foreign@example.com');

        $response = $this
            ->actingAs($user)
            ->getJson('/api/v1/orders');

        $response->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.id', $ownOrder->id)
            ->assertJsonPath('data.0.status.code', 0);
    }

    public function test_show_returns_only_owned_order_details() {
        $user = factory(User::class)->create();
        $otherUser = factory(User::class)->create();

        $ownOrder = $this->createOrderForUser($user, 'owned@example.com');
        $foreignOrder = $this->createOrderForUser($otherUser, 'hidden@example.com');

        $showResponse = $this
            ->actingAs($user)
            ->getJson('/api/v1/orders/'.$ownOrder->id);

        $showResponse->assertOk()
            ->assertJsonPath('data.id', $ownOrder->id)
            ->assertJsonPath('data.items.0.quantity', 1);

        $foreignResponse = $this
            ->actingAs($user)
            ->getJson('/api/v1/orders/'.$foreignOrder->id);

        $foreignResponse->assertNotFound();
    }

    private function createOrderForUser(User $user, $email) {
        $order = Order::create([
            'user_id' => $user->id,
            'name' => 'Order User',
            'email' => $email,
            'phone' => '+70000000020',
            'address' => 'Order street',
            'comment' => 'Order comment',
            'amount' => 500,
            'status' => 0,
        ]);

        $order->items()->create([
            'product_id' => null,
            'name' => 'Order item',
            'price' => 500,
            'quantity' => 1,
            'cost' => 500,
        ]);

        return $order;
    }
}
