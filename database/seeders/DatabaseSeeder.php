<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        app()->environment('local')
            ? $this->seedForDev()
            : $this->seedForProduction();
    }

    private function seedForDev()
    {
        $this->call([
            RoleSeeder::class,
            AdminSeeder::class,
            PermissionSeeder::class,
            EmployeeSeeder::class,
            SupportSeeder::class,
        ]);
    }

    private function seedForProduction()
    {
        $this->call([
            RoleSeeder::class,
            AdminSeeder::class,
            PermissionSeeder::class,
        ]);
    }
}
