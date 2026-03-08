<?php

namespace Tests\Feature\Api;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileApiTest extends TestCase {
    use RefreshDatabase;

    public function test_unauthenticated_user_cannot_access_profiles() {
        $response = $this->getJson('/api/v1/profiles');

        $response->assertUnauthorized();
    }

    public function test_index_returns_only_authenticated_users_profiles() {
        $user = factory(User::class)->create();
        $token = $user->createToken('profiles-index')->plainTextToken;
        $otherUser = factory(User::class)->create();

        Profile::create([
            'user_id' => $user->id,
            'title' => 'Main',
            'name' => 'User One',
            'email' => 'user1@example.com',
            'phone' => '+70000000010',
            'address' => 'Address one',
            'comment' => 'Comment one',
        ]);
        Profile::create([
            'user_id' => $otherUser->id,
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

    public function test_store_ignores_client_side_user_id() {
        $user = factory(User::class)->create();
        $token = $user->createToken('profiles-store')->plainTextToken;
        $otherUser = factory(User::class)->create();

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

        $this->assertEquals($user->id, Profile::first()->user_id);
    }

    public function test_foreign_profile_is_not_accessible() {
        $user = factory(User::class)->create();
        $token = $user->createToken('profiles-foreign')->plainTextToken;
        $otherUser = factory(User::class)->create();
        $profile = Profile::create([
            'user_id' => $otherUser->id,
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
