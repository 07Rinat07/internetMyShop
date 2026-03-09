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
            ->withCookie('basket_id', (string) $basket->id)
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
        $this->assertSame('manager_confirmation', $order->payment_method);
        $this->assertSame('KZT', $order->currency);
        $this->assertCount(1, $order->items);
        $this->assertSame(0, $basket->fresh()->products()->count());
    }

    public function test_online_card_checkout_returns_json_payment_payload_for_legacy_storefront(): void
    {
        config()->set('payments.default', 'fake');
        config()->set('payments.providers.fake.currency', 'KZT');

        $category = Category::factory()->create([
            'parent_id' => 0,
            'name' => 'Hosted category',
            'slug' => 'hosted-category',
        ]);
        $brand = Brand::factory()->create([
            'name' => 'Hosted brand',
            'slug' => 'hosted-brand',
        ]);
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'name' => 'Hosted product',
            'slug' => 'hosted-product',
            'price' => 2100,
        ]);
        $basket = Basket::create();
        $basket->products()->attach($product->id, ['quantity' => 1]);

        $response = $this
            ->withCookie('basket_id', (string) $basket->id)
            ->post(route('basket.saveorder'), [
                'name' => 'Card Buyer',
                'email' => 'card@example.com',
                'phone' => '+77777777778',
                'address' => 'Hosted street',
                'comment' => 'Use card',
                'payment_method' => 'online_card',
            ], [
                'Accept' => 'application/json',
            ]);

        $response->assertCreated()
            ->assertJsonPath('data.order.payment_method.code', 'online_card')
            ->assertJsonPath('data.payment.provider.code', 'fake')
            ->assertJsonPath('data.payment.checkout_flow', 'hosted_fields');
    }

    public function test_plain_basket_cookie_cannot_open_existing_basket() {
        $category = Category::factory()->create([
            'parent_id' => 0,
            'name' => 'Isolation category',
            'slug' => 'isolation-category',
        ]);
        $brand = Brand::factory()->create([
            'name' => 'Isolation brand',
            'slug' => 'isolation-brand',
        ]);
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'name' => 'Isolation product',
            'slug' => 'isolation-product',
            'price' => 1500,
        ]);
        $basket = Basket::create();
        $basket->products()->attach($product->id, ['quantity' => 1]);

        $response = $this
            ->withUnencryptedCookie('basket_id', (string) $basket->id)
            ->get(route('basket.index'));

        $response
            ->assertOk()
            ->assertDontSee('Isolation product');
    }
}
