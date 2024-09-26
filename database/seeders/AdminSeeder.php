<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::firstOrCreate([
            'email' => config('app.superadmin.email'),
        ], [
            'name' => 'Admin',
            'password' => config('app.superadmin.password'),
        ]);

        $admin->assignRole(
            role: UserRole::ADMIN->asModel(),
        );
    }
}
