<?php

namespace Database\Seeders;

use App\Seeders\AdminUserSeeder;
use App\Seeders\DemoCatalogSeeder;
use App\Seeders\DemoUserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            DemoUserSeeder::class,
            DemoCatalogSeeder::class,
            StorefrontSiteContentSeeder::class,
        ]);
    }
}
