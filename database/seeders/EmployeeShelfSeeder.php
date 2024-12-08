<?php

namespace Database\Seeders;

use App\Models\Shelf;
use App\Models\Employee;
use App\Models\Warehouse;
use App\Enums\EmployeeRole;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EmployeeShelfSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->seedTabukShelves();
        $this->seedRiyadhShelves();
    }

    private function seedTabukShelves()
    {
        $tabukWarehouse = Warehouse::firstWhere('name', 'تبوك');

        if (! $tabukWarehouse) {
            return;
        }

        $employeesData = [
            [
                'email' => 'abogmal4335@gmail.com',
                'aisles' => ['F', 'G', 'H', 'I', 'J', 'K', 'L', 'N', 'X'],
                'shelves' => [
                    'B19',
                    'C19',
                    'E1', 'E2', 'E3', 'E4', 'E5', 'E6', 'E7', 'E8', 'E9', 'E10', 'E11', 'E12', 'E13', 'E14', 'E15', 'E17', 'E19',
                    'O1', 'O7', 'O8', 'O9', 'O10', 'O11', 'O12', 'O13', 'O14', 'O15', 'O16', 'O17', 'O18', 'O19', 'O20', 'O21', 'O22', 'O23', 'O24',
                ],
            ],
            [
                'email' => 'abobakr.sadig96@gmail.com',
                'aisles' => ['A', 'D'],
                'shelves' => [
                    'B1', 'B2', 'B3', 'B4', 'B5', 'B6', 'B7', 'B8', 'B9', 'B10', 'B11', 'B12', 'B13', 'B14', 'B15', 'B16','B17','B18',
                    'C9', 'C17',
                ],
            ],
            [
                'email' => 's3eed1818h@gmail.com',
                'aisles' => ['M'],
                'shelves' => [
                    'C1', 'C2', 'C3', 'C4', 'C5', 'C6', 'C7', 'C8', 'C10', 'C11', 'C12', 'C13', 'C14', 'C15', 'C16', 'C18',
                    'E16', 'E18',
                    'O2', 'O3', 'O4', 'O5', 'O6',
                ],
            ],
            [
                'email' => 'alayham779@gmail.com',
                'aisles' => ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'X'],
                'shelves' => [

                ],
            ],
        ];

        $employees = Employee::query()
            ->whereIn('email', array_column($employeesData, 'email'))
            ->get();

        foreach ($employees as $employee) {
            if (! $employee->hasRole(EmployeeRole::STOCKTAKING)) {
                $employee->update([
                    'roles' => array_merge($employee->roles, [EmployeeRole::STOCKTAKING->value]),
                ]);
            }
        }

        foreach ($employeesData as $employeeData) {
            $employee = $employees->where('email', $employeeData['email'])->first();

            if (! $employee) {
                continue;
            }

            foreach ($employeeData['aisles'] ?? [] as $aisle) {
                $shelfIds = Shelf::where('warehouse_id', $tabukWarehouse->id)
                    ->where('aisle', $aisle)
                    ->pluck('id')
                    ->toArray();

                if (empty($shelfIds)) {
                    continue;
                }

                $employee->shelves()->syncWithoutDetaching($shelfIds);
            }

            $shelfIds = Shelf::where('warehouse_id', $tabukWarehouse->id)
                ->whereIn('name', $employeeData['shelves'])
                ->pluck('id')
                ->toArray();

            if (empty($shelfIds)) {
                continue;
            }

            $employee->shelves()->syncWithoutDetaching($shelfIds);
        }
    }

    private function seedRiyadhShelves()
    {

    }
}
