<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        return;

        $permissions = [
            // Marketers
            'view_marketers',
            'create_marketers',
            'update_marketers',
            'delete_marketers',

            // Products
            'view_products',

            // Order Statuses
            'view_order_statuses',

            // Payment Terms
            'view_payment_terms',
            'update_payment_terms',

            // Orders
            'view_orders',

            // Coupons
            'view_coupons',
            'update_coupons',

            // Payments
            'view_payments',
            'create_payments',
            'update_payments',
            'delete_payments',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'admin',
            ], []);
        }

        Permission::whereNotIn('name', $permissions)->delete();

        $adminRole = Role::where('name', 'admin')->first();

        if ($adminRole) {
            $adminRole->syncPermissions(Permission::all());
        }
    }
}
