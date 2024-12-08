<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Enums\EmployeeRole;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FixEmployeeRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employee::query()
            ->whereNull('roles')
            ->update([
                'roles' => [
                    EmployeeRole::ORDERS_FULFILLMENT->value,
                ],
            ]);
    }
}
