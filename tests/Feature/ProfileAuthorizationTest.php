<?php

namespace Tests\Feature;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileAuthorizationTest extends TestCase {
    use RefreshDatabase;

    public function test_user_cannot_update_foreign_profile() {
        $owner = factory(User::class)->create();
        $intruder = factory(User::class)->create();

        $profile = Profile::create([
            'user_id' => $owner->id,
            'title' => 'Основной',
            'name' => 'Owner User',
            'email' => 'owner@example.com',
            'phone' => '+70000000000',
            'address' => 'Owner street',
            'comment' => 'Owner comment',
        ]);

        $response = $this
            ->actingAs($intruder)
            ->put(route('user.profile.update', ['profile' => $profile->id]), [
                'title' => 'Взлом',
                'name' => 'Intruder',
                'email' => 'intruder@example.com',
                'phone' => '+71111111111',
                'address' => 'Intruder street',
                'comment' => 'Intruder comment',
                'user_id' => $intruder->id,
            ]);

        $response->assertNotFound();
        $this->assertEquals($owner->id, $profile->fresh()->user_id);
        $this->assertSame('Owner User', $profile->fresh()->name);
    }
}
