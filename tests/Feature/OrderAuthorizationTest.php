<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_view_foreign_order(): void
    {
        $owner = User::factory()->create();
        $intruder = User::factory()->create();

        $order = new Order([
            'name' => 'Owner order',
            'email' => 'owner-order@example.test',
            'phone' => '+70000000021',
            'address' => 'Owner street',
            'comment' => 'Owner comment',
            'status' => 0,
        ]);
        $order->user()->associate($owner);
        $order->amount = 500;
        $order->save();

        $response = $this
            ->actingAs($intruder)
            ->get(route('user.order.show', ['order' => $order->id]));

        $response->assertNotFound();
    }
}
