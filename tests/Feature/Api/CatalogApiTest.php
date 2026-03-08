<?php

namespace Tests\Feature\Api;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogApiTest extends TestCase {
    use RefreshDatabase;

    public function test_catalog_index_returns_categories_and_brands() {
        $category = factory(Category::class)->create([
            'parent_id' => 0,
            'name' => 'Категория',
            'slug' => 'category-root',
        ]);

        factory(Category::class)->create([
            'parent_id' => $category->id,
            'name' => 'Подкатегория',
            'slug' => 'category-child',
        ]);

        $brand = factory(Brand::class)->create([
            'name' => 'Бренд',
            'slug' => 'brand-root',
        ]);

        $response = $this->getJson('/api/v1/catalog');

        $response->assertOk()
            ->assertJsonFragment([
                'slug' => 'category-root',
            ])
            ->assertJsonFragment([
                'slug' => 'brand-root',
            ]);
    }

    public function test_category_endpoint_returns_paginated_products() {
        $category = factory(Category::class)->create([
            'parent_id' => 0,
            'name' => 'Категория',
            'slug' => 'api-category',
        ]);
        $brand = factory(Brand::class)->create([
            'name' => 'Бренд',
            'slug' => 'api-brand',
        ]);
        $product = factory(Product::class)->create([
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'name' => 'Товар API',
            'slug' => 'api-product',
            'price' => 1999,
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
    }

    public function test_brand_endpoint_returns_paginated_products() {
        $category = factory(Category::class)->create([
            'parent_id' => 0,
            'name' => 'Категория',
            'slug' => 'api-category-brand',
        ]);
        $brand = factory(Brand::class)->create([
            'name' => 'Бренд API',
            'slug' => 'api-brand-show',
        ]);
        $product = factory(Product::class)->create([
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'name' => 'Товар бренда',
            'slug' => 'brand-product',
            'price' => 2499,
        ]);

        $response = $this->getJson('/api/v1/brands/'.$brand->slug);

        $response->assertOk()
            ->assertJsonPath('data.brand.slug', $brand->slug)
            ->assertJsonPath('data.products.0.slug', $product->slug);
    }

    public function test_product_endpoint_returns_product_detail() {
        $category = factory(Category::class)->create([
            'parent_id' => 0,
            'name' => 'Категория',
            'slug' => 'api-category-detail',
        ]);
        $brand = factory(Brand::class)->create([
            'name' => 'Бренд detail',
            'slug' => 'api-brand-detail',
        ]);
        $product = factory(Product::class)->create([
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'name' => 'Детальный товар',
            'slug' => 'product-detail',
            'price' => 3999,
        ]);

        $response = $this->getJson('/api/v1/products/'.$product->slug);

        $response->assertOk()
            ->assertJsonPath('data.slug', $product->slug)
            ->assertJsonPath('data.brand.slug', $brand->slug)
            ->assertJsonPath('data.category.slug', $category->slug);
    }
}
