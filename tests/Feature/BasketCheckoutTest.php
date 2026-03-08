<?php

namespace Tests\Feature;

use App\Models\Basket;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BasketCheckoutTest extends TestCase {
    use RefreshDatabase;

    public function test_checkout_ignores_client_side_amount_status_and_user_id() {
        $category = Category::factory()->create([
            'parent_id' => 0,
            'name' => 'Checkout category',
            'slug' => 'checkout-category',
        ]);
        $brand = Brand::factory()->create([
            'name' => 'Checkout brand',
            'slug' => 'checkout-brand',
        ]);
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'name' => 'Checkout product',
            'slug' => 'checkout-product',
            'price' => 1200,
        ]);
        $basket = Basket::create();
        $basket->products()->attach($product->id, ['quantity' => 2]);

        $response = $this
            ->disableCookieEncryption()
            ->withUnencryptedCookie('basket_id', (string)$basket->id)
            ->post(route('basket.saveorder'), [
                'name' => 'Ivan Ivanov',
                'email' => 'ivan@example.com',
                'phone' => '+77777777777',
                'address' => 'Test street',
                'comment' => 'Test comment',
                'amount' => 1,
                'status' => 4,
                'user_id' => 999,
            ]);

        $order = Order::first();

        $response->assertRedirect(route('basket.success'));
        $this->assertNotNull($order);
        $this->assertEquals(2400, $order->amount);
        $this->assertEquals(0, $order->status);
        $this->assertNull($order->user_id);
        $this->assertCount(1, $order->items);
        $this->assertSame(0, $basket->fresh()->products()->count());
    }
}
