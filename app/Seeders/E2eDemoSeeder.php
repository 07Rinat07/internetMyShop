<?php

namespace App\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class E2eDemoSeeder extends Seeder
{
    public function run()
    {
        $user = User::create([
            'name' => 'E2E Buyer',
            'email' => 'buyer@example.test',
            'password' => Hash::make('Password123!'),
            'email_verified_at' => now(),
        ]);

        Profile::create([
            'user_id' => $user->id,
            'title' => 'Primary checkout profile',
            'name' => 'E2E Buyer',
            'email' => 'buyer@example.test',
            'phone' => '+7 700 000 0000',
            'address' => '123 Test Street, Demo City',
            'comment' => 'Leave at the front desk.',
        ]);

        $category = Category::create([
            'parent_id' => 0,
            'name' => 'E2E Packs',
            'slug' => 'e2e-packs',
            'content' => 'Deterministic category for browser tests.',
            'image' => null,
        ]);

        $brand = Brand::create([
            'name' => 'E2E Trail',
            'slug' => 'e2e-trail',
            'content' => 'Deterministic brand for browser tests.',
            'image' => null,
        ]);

        Product::create([
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'name' => 'E2E Backpack',
            'slug' => 'e2e-backpack',
            'content' => 'Main browser-test product.',
            'image' => null,
            'price' => 149.99,
            'new' => true,
            'hit' => true,
            'sale' => false,
        ]);

        Product::create([
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'name' => 'E2E Flask',
            'slug' => 'e2e-flask',
            'content' => 'Secondary browser-test product.',
            'image' => null,
            'price' => 24.50,
            'new' => false,
            'hit' => false,
            'sale' => true,
        ]);
    }
}
