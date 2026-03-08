<?php

namespace App\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        $admin = User::firstOrNew([
            'email' => 'admin@example.test',
        ]);

        $admin->forceFill([
            'name' => 'Demo Admin',
            'email' => 'admin@example.test',
            'password' => Hash::make('Password123!'),
            'email_verified_at' => now(),
            'admin' => true,
            'remember_token' => Str::random(10),
        ]);

        $admin->save();
    }
}
