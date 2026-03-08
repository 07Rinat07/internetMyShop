<?php

namespace App\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DemoUserSeeder extends Seeder
{
    public function run()
    {
        $user = User::firstOrNew([
            'email' => 'user@example.test',
        ]);

        $user->forceFill([
            'name' => 'Demo Customer',
            'email' => 'user@example.test',
            'password' => Hash::make('Password123!'),
            'email_verified_at' => now(),
            'admin' => false,
            'remember_token' => Str::random(10),
        ]);

        $user->save();

        Profile::updateOrCreate(
            [
                'user_id' => $user->id,
                'title' => 'Home Delivery',
            ],
            [
                'name' => 'Demo Customer',
                'email' => 'user@example.test',
                'phone' => '+7 700 123 4567',
                'address' => '15 Demo Street, Test City',
                'comment' => 'Test profile for checkout flows.',
            ]
        );
    }
}
