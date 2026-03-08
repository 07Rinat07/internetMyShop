<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\MoonShine\Resources\SiteContent\SiteContentResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminSiteContentManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_site_content_override_from_moonshine(): void
    {
        $admin = User::factory()->create(['admin' => true]);

        $response = $this
            ->actingAs($admin)
            ->post(route('moonshine.crud.store', [
                'resourceUri' => app(SiteContentResource::class)->getUriKey(),
            ]), [
                'locale' => 'ru',
                'section' => 'header',
                'label' => 'Header: Tagline',
                'key' => 'header.tagline',
                'value' => 'Премиальный outdoor-магазин с управляемым контентом.',
                'sort_order' => 10,
            ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('site_contents', [
            'locale' => 'ru',
            'key' => 'header.tagline',
            'value' => 'Премиальный outdoor-магазин с управляемым контентом.',
        ]);

        $siteResponse = $this->get(route('index'));

        $siteResponse
            ->assertOk()
            ->assertSeeText('Премиальный outdoor-магазин с управляемым контентом.');
    }

    public function test_admin_can_open_site_content_index_page(): void
    {
        $admin = User::factory()->create(['admin' => true]);

        $response = $this
            ->actingAs($admin)
            ->get(app(SiteContentResource::class)->getIndexPageUrl());

        $response
            ->assertOk()
            ->assertSeeText('Контент витрины');
    }
}
