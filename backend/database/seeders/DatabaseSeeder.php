<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SystemSettingSeeder::class,
            AdminSeeder::class,
            ProductCategorySeeder::class,
            MaterialSeeder::class,
            PackagingSeeder::class,
        ]);
    }
}
