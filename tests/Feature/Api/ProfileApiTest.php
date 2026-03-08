<?php

namespace Tests\Feature\Api;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_user_cannot_access_profiles()
    {
        $response = $this->getJson('/api/v1/profiles');

        $response->assertUnauthorized();
    }

    public function test_index_returns_only_authenticated_users_profiles()
    {
        $user = User::factory()->create();
        $token = $user->createToken('profiles-index')->plainTextToken;
        $otherUser = User::factory()->create();

        $user->profiles()->create([
            'title' => 'Main',
            'name' => 'User One',
            'email' => 'user1@example.com',
            'phone' => '+70000000010',
            'address' => 'Address one',
            'comment' => 'Comment one',
        ]);
        $otherUser->profiles()->create([
            'title' => 'Foreign',
            'name' => 'User Two',
            'email' => 'user2@example.com',
            'phone' => '+70000000011',
            'address' => 'Address two',
            'comment' => 'Comment two',
        ]);

        $response = $this
            ->withToken($token)
            ->getJson('/api/v1/profiles');

        $response->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.email', 'user1@example.com');
    }

    public function test_store_ignores_client_side_user_id()
    {
        $user = User::factory()->create();
        $token = $user->createToken('profiles-store')->plainTextToken;
        $otherUser = User::factory()->create();

        $response = $this
            ->withToken($token)
            ->postJson('/api/v1/profiles', [
                'user_id' => $otherUser->id,
                'title' => 'API profile',
                'name' => 'API User',
                'email' => 'api-profile@example.com',
                'phone' => '+70000000012',
                'address' => 'API address',
                'comment' => 'API comment',
            ]);

        $response->assertCreated()
            ->assertJsonPath('data.email', 'api-profile@example.com');

        /** @var Profile $profile */
        $profile = Profile::query()->firstOrFail();

        $this->assertEquals($user->id, $profile->user_id);
    }

    public function test_foreign_profile_is_not_accessible()
    {
        $user = User::factory()->create();
        $token = $user->createToken('profiles-foreign')->plainTextToken;
        $otherUser = User::factory()->create();
        /** @var Profile $profile */
        $profile = $otherUser->profiles()->create([
            'title' => 'Foreign',
            'name' => 'Foreign User',
            'email' => 'foreign@example.com',
            'phone' => '+70000000013',
            'address' => 'Foreign address',
            'comment' => 'Foreign comment',
        ]);

        $response = $this
            ->withToken($token)
            ->getJson('/api/v1/profiles/'.$profile->id);

        $response->assertNotFound();
    }
}
