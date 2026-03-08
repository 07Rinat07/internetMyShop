<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_search_matches_russian_word_forms_via_stemmer(): void
    {
        $category = Category::factory()->create([
            'name' => 'Сумки',
            'slug' => 'sumki',
        ]);

        $brand = Brand::factory()->create([
            'name' => 'TrailLab',
            'slug' => 'traillab',
        ]);

        Product::factory()->create([
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'name' => 'Туристический рюкзак',
            'slug' => 'tour-backpack',
            'content' => 'Удобный городской рюкзак для поездок.',
        ]);

        $response = $this->get(route('catalog.search', ['query' => 'рюкзаками']));

        $response->assertOk();
        $response->assertSee('Туристический рюкзак');
    }
}
