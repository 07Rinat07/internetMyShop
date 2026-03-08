<?php

namespace Tests\Feature;

use App\Models\SiteContent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SiteContentOverrideTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_uses_database_override_for_site_content(): void
    {
        SiteContent::query()->create([
            'locale' => 'ru',
            'section' => 'header',
            'label' => 'Header: Brand',
            'key' => 'header.brand',
            'value' => 'North Ridge Store',
            'sort_order' => 1,
        ]);

        $response = $this->get(route('index'));

        $response
            ->assertOk()
            ->assertSeeText('North Ridge Store');
    }

    public function test_catalog_page_uses_locale_specific_database_override(): void
    {
        SiteContent::query()->create([
            'locale' => 'en',
            'section' => 'catalog',
            'label' => 'Catalog: Headline',
            'key' => 'catalog.headline',
            'value' => 'Build your kit for mountain travel and long-range field movement.',
            'sort_order' => 1,
        ]);

        $response = $this
            ->withSession(['locale' => 'en'])
            ->get(route('catalog.index'));

        $response
            ->assertOk()
            ->assertSeeText('Build your kit for mountain travel and long-range field movement.');
    }
}
