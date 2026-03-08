<?php

namespace Tests\Feature\Api;

use App\Models\Basket;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BasketApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_item_endpoint_creates_basket_and_returns_payload()
    {
        $product = $this->createProduct('basket-product');

        $response = $this
            ->withCredentials()
            ->postJson('/api/v1/basket/items', [
                'product_id' => $product->id,
                'quantity' => 2,
            ]);

        $response->assertOk()
            ->assertJsonPath('data.positions', 1)
            ->assertJsonPath('data.items.0.product_id', $product->id)
            ->assertJsonPath('data.items.0.quantity', 2);

        $this->assertTrue($response->headers->has('Set-Cookie'));
    }

    public function test_show_update_and_remove_basket_item()
    {
        $product = $this->createProduct('basket-update-product');
        $basket = Basket::create();
        $basket->products()->attach($product->id, ['quantity' => 1]);

        $showResponse = $this
            ->withCredentials()
            ->withCookie('basket_id', (string) $basket->id)
            ->getJson('/api/v1/basket');

        $showResponse->assertOk()
            ->assertJsonPath('data.items.0.quantity', 1);

        $updateResponse = $this
            ->withCredentials()
            ->withCookie('basket_id', (string) $basket->id)
            ->patchJson('/api/v1/basket/items/'.$product->id, [
                'quantity' => 4,
            ]);

        $updateResponse->assertOk()
            ->assertJsonPath('data.items.0.quantity', 4);

        $deleteResponse = $this
            ->withCredentials()
            ->withCookie('basket_id', (string) $basket->id)
            ->deleteJson('/api/v1/basket/items/'.$product->id);

        $deleteResponse->assertOk()
            ->assertJsonPath('data.positions', 0);
    }

    public function test_checkout_endpoint_creates_order_and_clears_basket()
    {
        $user = User::factory()->create();
        $token = $user->createToken('basket-api-test')->plainTextToken;
        $product = $this->createProduct('basket-checkout-product', 1500);
        $basket = Basket::create();
        $basket->products()->attach($product->id, ['quantity' => 2]);

        $response = $this
            ->withCredentials()
            ->withToken($token)
            ->withCookie('basket_id', (string) $basket->id)
            ->postJson('/api/v1/basket/checkout', [
                'name' => 'Api Customer',
                'email' => 'api-customer@example.com',
                'phone' => '+70000000001',
                'address' => 'API street',
                'comment' => 'Checkout through API',
            ]);

        $response->assertCreated()
            ->assertJsonPath('data.amount', 3000)
            ->assertJsonPath('data.status.code', 0)
            ->assertJsonPath('data.items.0.quantity', 2);

        /** @var Order $order */
        $order = $user->fresh()->orders()->firstOrFail();

        $this->assertSame(0, $basket->fresh()->products()->count());
        $this->assertEquals($user->id, $order->user_id);
    }

    private function createProduct(string $slug, int $price = 1200): Product
    {
        $category = Category::factory()->create([
            'parent_id' => 0,
            'name' => 'Basket category '.$slug,
            'slug' => 'basket-category-'.$slug,
        ]);
        $brand = Brand::factory()->create([
            'name' => 'Basket brand '.$slug,
            'slug' => 'basket-brand-'.$slug,
        ]);

        return Product::factory()->create([
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'name' => 'Basket product '.$slug,
            'slug' => $slug,
            'price' => $price,
        ]);
    }
}
