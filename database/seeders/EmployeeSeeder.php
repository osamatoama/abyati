<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(1, 10) as $i) {
            Employee::create([
                'name' => 'موظف ' . $i,
                'email' => 'employee-' . $i . '@abyati.com',
                'password' => '123456',
                'active' => true,
                'phone' => '059999999' . ($i - 1),
            ]);
        }
    }
}
