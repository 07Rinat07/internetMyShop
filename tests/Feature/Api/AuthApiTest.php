<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\PersonalAccessToken;
use Tests\TestCase;

class AuthApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_returns_token_and_user_payload()
    {
        $response = $this->postJson('/api/v1/auth/register', [
            'name' => 'New Api User',
            'email' => 'new-api-user@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'device_name' => 'nuxt-dev',
        ]);

        $response->assertCreated()
            ->assertJsonPath('data.token_type', 'Bearer')
            ->assertJsonPath('data.user.email', 'new-api-user@example.com');

        $this->assertDatabaseHas('users', [
            'email' => 'new-api-user@example.com',
        ]);
        $this->assertSame(1, PersonalAccessToken::count());
    }

    public function test_login_me_and_logout_work_with_sanctum_token()
    {
        $user = User::factory()->create([
            'email' => 'login-api-user@example.com',
            'password' => bcrypt('password123'),
        ]);

        $loginResponse = $this->postJson('/api/v1/auth/login', [
            'email' => 'login-api-user@example.com',
            'password' => 'password123',
            'device_name' => 'nuxt-dev',
        ]);

        $token = $loginResponse->json('data.access_token');

        $loginResponse->assertOk()
            ->assertJsonPath('data.user.id', $user->id);

        $meResponse = $this
            ->withToken($token)
            ->getJson('/api/v1/auth/me');

        $meResponse->assertOk()
            ->assertJsonPath('data.email', 'login-api-user@example.com');

        $logoutResponse = $this
            ->withToken($token)
            ->postJson('/api/v1/auth/logout');

        $logoutResponse->assertNoContent();
        $this->assertSame(0, PersonalAccessToken::count());
    }

    public function test_login_rejects_invalid_credentials()
    {
        User::factory()->create([
            'email' => 'wrong-pass@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'wrong-pass@example.com',
            'password' => 'not-correct',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('email');
    }
}
