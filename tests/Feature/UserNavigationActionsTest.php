<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserNavigationActionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_account_section_shows_navigation_actions(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('user.index'));

        $response
            ->assertOk()
            ->assertSeeText(__('site.navigation.back'))
            ->assertSeeText(__('site.navigation.home'))
            ->assertDontSeeText(__('site.navigation.to_admin'))
            ->assertSeeText(__('site.account.logout'));
    }

    public function test_admin_user_sees_admin_panel_navigation_from_storefront(): void
    {
        $admin = User::factory()->create([
            'admin' => true,
        ]);

        $response = $this
            ->actingAs($admin)
            ->get(route('user.index'));

        $response
            ->assertOk()
            ->assertSeeText(__('site.header.admin'))
            ->assertSeeText(__('site.navigation.to_admin'));
    }
}
