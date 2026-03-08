<?php

namespace Tests\Feature\Admin;

use App\Models\Page;
use App\Models\User;
use App\MoonShine\Resources\Page\PageResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPageContentSanitizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_page_content_is_sanitized_before_persisting(): void
    {
        $admin = User::factory()->create(['admin' => true]);

        $response = $this
            ->actingAs($admin)
            ->post(route('moonshine.crud.store', [
                'resourceUri' => app(PageResource::class)->getUriKey(),
            ]), [
                'name' => 'Unsafe',
                'parent_id' => 0,
                'slug' => 'unsafe-page',
                'content' => '<p>Hello</p><script>alert(1)</script><img src="x" onerror="alert(1)"><a href="javascript:alert(1)">Click</a>',
            ]);

        $response->assertRedirect();

        $page = Page::query()->where('slug', 'unsafe-page')->firstOrFail();
        $this->assertStringNotContainsString('<script', $page->content);
        $this->assertStringNotContainsString('onerror', $page->content);
        $this->assertStringNotContainsString('javascript:', $page->content);
    }

    public function test_public_page_response_has_security_headers(): void
    {
        $page = Page::query()->create([
            'name' => 'Public',
            'slug' => 'public-page',
            'parent_id' => 0,
            'content' => '<p>Safe</p>',
        ]);

        $response = $this->get(route('page.show', ['page' => $page->slug]));

        $response->assertOk();
        $response->assertHeader('X-Frame-Options', 'DENY');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('Content-Security-Policy');
    }
}
