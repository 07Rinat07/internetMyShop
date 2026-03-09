<?php

namespace Tests\Feature\Api;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class CatalogApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_catalog_index_returns_categories_and_brands()
    {
        $category = Category::factory()->create([
            'parent_id' => 0,
            'name' => 'Категория',
            'slug' => 'category-root',
            'image' => 'category-root.jpg',
        ]);

        Category::factory()->create([
            'parent_id' => $category->id,
            'name' => 'Подкатегория',
            'slug' => 'category-child',
        ]);

        $brand = Brand::factory()->create([
            'name' => 'Бренд',
            'slug' => 'brand-root',
            'image' => 'brand-root.jpg',
        ]);

        $response = $this->getJson('/api/v1/catalog');

        $response->assertOk()
            ->assertJsonFragment([
                'slug' => 'category-root',
            ])
            ->assertJsonFragment([
                'slug' => 'brand-root',
            ]);

        $this->assertTrue(Str::contains((string) $response->json('data.categories.0.image'), '/storage/catalog/category/thumb/category-root.jpg'));
        $this->assertTrue(Str::contains((string) $response->json('data.brands.0.image'), '/storage/catalog/brand/thumb/brand-root.jpg'));
    }

    public function test_category_endpoint_returns_paginated_products()
    {
        $category = Category::factory()->create([
            'parent_id' => 0,
            'name' => 'Категория',
            'slug' => 'api-category',
        ]);
        $brand = Brand::factory()->create([
            'name' => 'Бренд',
            'slug' => 'api-brand',
        ]);
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'name' => 'Товар API',
            'slug' => 'api-product',
            'price' => 1999,
            'image' => 'api-product.jpg',
        ]);

        $response = $this->getJson('/api/v1/categories/'.$category->slug);

        $response->assertOk()
            ->assertJsonPath('data.category.slug', $category->slug)
            ->assertJsonPath('data.products.0.slug', $product->slug)
            ->assertJsonStructure([
                'data' => ['category', 'products'],
                'meta' => ['current_page', 'last_page', 'per_page', 'total'],
                'links' => ['first', 'last', 'prev', 'next'],
            ]);

        $this->assertTrue(Str::contains((string) $response->json('data.products.0.image'), '/storage/catalog/product/thumb/api-product.jpg'));
    }

    public function test_brand_endpoint_returns_paginated_products()
    {
        $category = Category::factory()->create([
            'parent_id' => 0,
            'name' => 'Категория',
            'slug' => 'api-category-brand',
        ]);
        $brand = Brand::factory()->create([
            'name' => 'Бренд API',
            'slug' => 'api-brand-show',
        ]);
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'name' => 'Товар бренда',
            'slug' => 'brand-product',
            'price' => 2499,
            'image' => 'brand-product.jpg',
        ]);

        $response = $this->getJson('/api/v1/brands/'.$brand->slug);

        $response->assertOk()
            ->assertJsonPath('data.brand.slug', $brand->slug)
            ->assertJsonPath('data.products.0.slug', $product->slug);

        $this->assertTrue(Str::contains((string) $response->json('data.products.0.image'), '/storage/catalog/product/thumb/brand-product.jpg'));
    }

    public function test_product_endpoint_returns_product_detail()
    {
        $category = Category::factory()->create([
            'parent_id' => 0,
            'name' => 'Категория',
            'slug' => 'api-category-detail',
        ]);
        $brand = Brand::factory()->create([
            'name' => 'Бренд detail',
            'slug' => 'api-brand-detail',
        ]);
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'name' => 'Детальный товар',
            'slug' => 'product-detail',
            'price' => 3999,
            'image' => 'product-detail.jpg',
        ]);

        $response = $this->getJson('/api/v1/products/'.$product->slug);

        $response->assertOk()
            ->assertJsonPath('data.slug', $product->slug)
            ->assertJsonPath('data.brand.slug', $brand->slug)
            ->assertJsonPath('data.category.slug', $category->slug);

        $this->assertTrue(Str::contains((string) $response->json('data.image'), '/storage/catalog/product/image/product-detail.jpg'));
    }
}
