<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->create(
                attributes: [
                    'name' => 'Admin',
                    'email' => config('app.superadmin.email'),
                    'password' => config('app.superadmin.password'),
                ],
            )
            ->assignRole(
                role: UserRole::ADMIN->asModel(),
            );
    }
}
