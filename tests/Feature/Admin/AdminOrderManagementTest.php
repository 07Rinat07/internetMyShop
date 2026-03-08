<?php

namespace Tests\Feature\Admin;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\User;
use App\MoonShine\Resources\Order\OrderResource;
use App\MoonShine\Resources\Product\ProductResource;
use App\MoonShine\Resources\User\UserResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminOrderManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_moonshine_dashboard(): void
    {
        $admin = User::factory()->create(['admin' => true]);

        $response = $this
            ->actingAs($admin)
            ->get(route('moonshine.index'));

        $response
            ->assertOk()
            ->assertSeeText(__('site.navigation.to_site'))
            ->assertSeeText(__('site.account.logout'))
            ->assertSee(app(ProductResource::class)->getIndexPageUrl(), false)
            ->assertSee(app(OrderResource::class)->getIndexPageUrl(), false)
            ->assertSee(app(UserResource::class)->getIndexPageUrl(), false)
            ->assertDontSee(route('moonshine.crud.index', [
                'resourceUri' => app(ProductResource::class)->getUriKey(),
            ]), false);
    }

    public function test_non_admin_cannot_access_moonshine_dashboard(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('moonshine.index'));

        $response->assertForbidden();
    }

    public function test_admin_updates_only_order_status(): void
    {
        $admin = User::factory()->create(['admin' => true]);
        $owner = User::factory()->create();
        $order = $this->createOrder($owner);

        $response = $this
            ->actingAs($admin)
            ->from(route('moonshine.index'))
            ->put(route('moonshine.crud.update', [
                'resourceUri' => app(OrderResource::class)->getUriKey(),
                'resourceItem' => $order->id,
            ]), [
                'status' => OrderStatus::Processed->value,
                'amount' => 1,
                'user_id' => $admin->id,
            ]);

        $response->assertRedirect();

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
