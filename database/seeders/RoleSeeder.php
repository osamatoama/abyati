<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (UserRole::cases() as $role) {
            Role::query()
                ->firstOrCreate(
                    attributes: [
                        'name' => $role->value,
                        'guard_name' => $role->guardName(),
                    ],
                );
        }
    }
}
