<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminLoginLocalizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_moonshine_login_page_uses_russian_translations(): void
    {
        $this->get(route('moonshine.login'))
            ->assertOk()
            ->assertSeeText('Добро пожаловать в InternetMyShop Admin!')
            ->assertSeeText('Войдите в свою учётную запись')
            ->assertSeeText('Запомнить меня')
            ->assertSeeText('Войти')
            ->assertDontSeeText('moonshine::ui.login.title')
            ->assertDontSeeText('moonshine::ui.login.description');
    }

    public function test_stale_admin_session_redirects_to_moonshine_login(): void
    {
        $admin = User::factory()->create(['admin' => true]);

        $this
            ->actingAs($admin)
            ->withSession(['password_hash_web' => 'stale-session-hash'])
            ->get(route('moonshine.login'))
            ->assertRedirect(route('moonshine.login'));
    }
}
