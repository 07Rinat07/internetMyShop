<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Page;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StorefrontPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_and_catalog_pages_render_public_content(): void
    {
        $alpine = Category::factory()->create([
            'parent_id' => 0,
            'name' => 'Alpine Gear',
            'slug' => 'alpine',
        ]);
        Category::factory()->create([
            'parent_id' => 0,
            'name' => 'Basecamp Gear',
            'slug' => 'basecamp',
        ]);
        $brand = Brand::factory()->create([
            'name' => 'North Line',
            'slug' => 'north-line',
        ]);

        Product::factory()->create([
            'category_id' => $alpine->id,
            'brand_id' => $brand->id,
            'name' => 'Glacier Shell',
            'slug' => 'glacier-shell',
            'new' => true,
        ]);

        // The homepage and catalog use different queries, so both pages are asserted in one scenario.
        $indexResponse = $this->get(route('index'));
        $catalogResponse = $this->get(route('catalog.index'));

        $indexResponse->assertOk()
            ->assertSeeText('Glacier Shell')
            ->assertSeeText(__('site.home.section_new'));

        $catalogResponse->assertOk()
            ->assertSeeText('Alpine Gear')
            ->assertSeeText('North Line');
    }

    public function test_catalog_detail_pages_render_category_brand_and_product_context(): void
    {
        $category = Category::factory()->create([
            'parent_id' => 0,
            'name' => 'Trail Packs',
            'slug' => 'trail-packs',
        ]);
        $brand = Brand::factory()->create([
            'name' => 'Summit Works',
            'slug' => 'summit-works',
        ]);
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'name' => 'Range Pack',
            'slug' => 'range-pack',
            'content' => 'Built for long-range carry.',
        ]);

        $this->get(route('catalog.category', ['category' => $category->slug]))
            ->assertOk()
            ->assertSeeText('Trail Packs')
            ->assertSeeText('Range Pack');

        $this->get(route('catalog.brand', ['brand' => $brand->slug]))
            ->assertOk()
            ->assertSeeText('Summit Works')
            ->assertSeeText('Range Pack');

        $this->get(route('catalog.product', ['product' => $product->slug]))
            ->assertOk()
            ->assertSeeText('Range Pack')
            ->assertSeeText('Built for long-range carry.');
    }

    public function test_static_page_route_renders_saved_page(): void
    {
        $page = Page::query()->create([
            'parent_id' => 0,
            'name' => 'Delivery',
            'slug' => 'delivery',
            'content' => '<p>Shipping details for every region.</p>',
        ]);

        $response = $this->get(route('page.show', ['page' => $page->slug]));

        $response->assertOk()
            ->assertSeeText('Delivery')
            ->assertSeeText('Shipping details for every region.');
    }
}
