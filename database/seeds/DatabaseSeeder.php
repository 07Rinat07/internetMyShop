<?php

use App\Seeders\AdminUserSeeder;
use App\Seeders\DemoCatalogSeeder;
use App\Seeders\DemoUserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminUserSeeder::class);
        $this->command->info('Создан тестовый администратор: admin@example.test / Password123!');

        $this->call(DemoUserSeeder::class);
        $this->command->info('Создан тестовый пользователь: user@example.test / Password123!');

        $this->call(DemoCatalogSeeder::class);
        $this->command->info('Загружены демо-категории, бренды и товары.');
    }
}
