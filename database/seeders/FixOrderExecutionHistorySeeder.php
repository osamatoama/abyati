<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;
use App\Models\OrderExecutionHistory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FixOrderExecutionHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orderExecutionHistories = OrderExecutionHistory::query()
            ->whereNotNull('employee_id')
            ->whereNull('executor_id')
            ->get();

        foreach ($orderExecutionHistories as $orderExecutionHistory) {
            $orderExecutionHistory->update([
                'executor_id' => $orderExecutionHistory->employee_id,
                'executor_type' => Employee::class,
            ]);
        }
    }
}
