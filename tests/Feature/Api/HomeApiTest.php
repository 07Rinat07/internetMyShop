<?php

namespace Tests\Feature\Api;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class HomeApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_endpoint_returns_storefront_sections_and_editorials(): void
    {
        $alpine = Category::factory()->create([
            'parent_id' => 0,
            'name' => 'Alpine',
            'slug' => 'alpine',
            'image' => 'alpine-home.jpg',
        ]);

        Category::factory()->create([
            'parent_id' => 0,
            'name' => 'Basecamp',
            'slug' => 'basecamp',
            'image' => 'basecamp-home.jpg',
        ]);

        $brand = Brand::factory()->create([
            'name' => 'Brand',
            'slug' => 'brand-home',
        ]);

        Product::factory()->create([
            'category_id' => $alpine->id,
            'brand_id' => $brand->id,
            'slug' => 'home-new-product',
            'image' => 'home-new.jpg',
            'new' => true,
            'hit' => false,
            'sale' => false,
        ]);

        Product::factory()->create([
            'category_id' => $alpine->id,
            'brand_id' => $brand->id,
            'slug' => 'home-hit-product',
            'image' => 'home-hit.jpg',
            'new' => false,
            'hit' => true,
            'sale' => false,
        ]);

        Product::factory()->create([
            'category_id' => $alpine->id,
            'brand_id' => $brand->id,
            'slug' => 'home-sale-product',
            'image' => 'home-sale.jpg',
            'new' => false,
            'hit' => false,
            'sale' => true,
        ]);

        $response = $this->getJson('/api/v1/home');

        $response->assertOk()
            ->assertJsonPath('data.new.0.slug', 'home-new-product')
            ->assertJsonPath('data.hit.0.slug', 'home-hit-product')
            ->assertJsonPath('data.sale.0.slug', 'home-sale-product')
            ->assertJsonPath('data.editorials.0.category.slug', 'alpine');

        $this->assertTrue(Str::contains((string) $response->json('data.new.0.image'), '/storage/catalog/product/thumb/home-new.jpg'));
        $this->assertTrue(Str::contains((string) $response->json('data.editorials.0.category.image'), '/storage/catalog/category/thumb/alpine-home.jpg'));
    }
}
