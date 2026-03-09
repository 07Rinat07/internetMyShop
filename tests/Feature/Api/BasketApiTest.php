<?php

namespace Tests\Feature\Api;

use App\Enums\PaymentStatus;
use App\Models\Basket;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
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
        config()->set('payments.default', 'paypal');
        config()->set('payments.store_currency', 'KZT');
        config()->set('payments.providers.paypal.currency', 'USD');
        config()->set('payments.providers.paypal.exchange_rate', 500);
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

            if (str_ends_with($url, '/v2/checkout/orders')) {
                return Http::response([
                    'id' => 'PAYPAL-ORDER-1',
                    'status' => 'CREATED',
                ], 201);
            }

            return Http::response([], 500);
        });

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
                'payment_method' => 'online_card',
            ]);

        $response->assertCreated()
            ->assertJsonPath('data.order.amount', 3000)
            ->assertJsonPath('data.order.currency', 'KZT')
            ->assertJsonPath('data.order.status.code', 0)
            ->assertJsonPath('data.order.payment_method.code', 'online_card')
            ->assertJsonPath('data.order.items.0.quantity', 2)
            ->assertJsonPath('data.payment.provider.code', 'paypal')
            ->assertJsonPath('data.payment.amount', 6)
            ->assertJsonPath('data.payment.currency', 'USD')
            ->assertJsonPath('data.payment.store_amount', 3000)
            ->assertJsonPath('data.payment.store_currency', 'KZT')
            ->assertJsonPath('data.payment.checkout_flow', 'hosted_fields')
            ->assertJsonPath('data.payment.status.code', PaymentStatus::Pending->value)
            ->assertJsonPath('data.payment.redirect_url', null);

        /** @var Order $order */
        $order = $user->fresh()->orders()->firstOrFail();
        /** @var Payment $payment */
        $payment = Payment::query()->where('order_id', $order->id)->firstOrFail();

        $this->assertSame(0, $basket->fresh()->products()->count());
        $this->assertEquals($user->id, $order->user_id);
        $this->assertSame('paypal', $payment->provider);
        $this->assertSame('PAYPAL-ORDER-1', $payment->provider_payment_id);
        $this->assertSame('online_card', $order->payment_method);
    }

    public function test_checkout_with_manager_confirmation_skips_payment_creation(): void
    {
        $product = $this->createProduct('basket-manager-checkout-product', 1800);
        $basket = Basket::create();
        $basket->products()->attach($product->id, ['quantity' => 1]);

        $response = $this
            ->withCredentials()
            ->withCookie('basket_id', (string) $basket->id)
            ->postJson('/api/v1/basket/checkout', [
                'name' => 'Manual Customer',
                'email' => 'manual@example.com',
                'phone' => '+70000000002',
                'address' => 'Manual street',
                'comment' => 'Call me first',
                'payment_method' => 'manager_confirmation',
            ]);

        $response->assertCreated()
            ->assertJsonPath('data.order.amount', 1800)
            ->assertJsonPath('data.order.payment_method.code', 'manager_confirmation')
            ->assertJsonPath('data.payment', null);

        $this->assertSame(0, $basket->fresh()->products()->count());
        $this->assertSame(0, Payment::query()->count());
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
