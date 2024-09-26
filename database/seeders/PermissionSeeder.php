<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'stores' => ['show', 'edit'],
            'branches' => ['show', 'add', 'edit', 'delete'],
            'products' => ['show'],
            'roles' => ['show', 'add', 'edit', 'delete'],
            'orders' => ['show', 'assign', 'pull', 'export'],
            'users' => ['show', 'add', 'edit', 'delete'],
            'employees' => ['show', 'add', 'edit', 'delete'],
            'supports' => ['show', 'add', 'edit', 'delete'],
        ];

        $permissionNames = [];

        foreach ($permissions as $tag => $actions) {
            foreach ($actions as $action) {
                $permissionNames[] = "$tag.$action";

                if (! Permission::where('name', "$tag.$action")->first()) {
                    Permission::create(
                        [
                            'tag' => $tag,
                            'name' => "$tag.$action",
                            'guard_name' => 'admin',
                        ]
                    );
                }
            }
        }

        Permission::whereNotIn('name', $permissionNames)->delete();
    }
}
