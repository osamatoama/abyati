<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Employee;
use Illuminate\Support\Arr;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branchIds = Branch::pluck('id')->toArray();

        foreach (range(1, 10) as $i) {
            Employee::create([
                'branch_id' => Arr::random($branchIds),
                'name' => 'موظف ' . $i,
                'email' => 'employee-' . $i . '@abyati.com',
                'password' => '123456',
                'active' => true,
                'phone' => '059999999' . ($i - 1),
            ]);
        }
    }
}
