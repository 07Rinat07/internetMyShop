<?php

namespace Tests\Feature;

use Tests\TestCase;

class LocaleSwitchTest extends TestCase
{
    public function test_locale_switch_route_sets_session_and_locale_cookie(): void
    {
        $response = $this
            ->from('/checkout')
            ->get('/locale/en');

        $response->assertRedirect('/checkout');
        $response->assertPlainCookie('locale', 'en');
        $this->assertSame('en', session('locale'));
    }
}
