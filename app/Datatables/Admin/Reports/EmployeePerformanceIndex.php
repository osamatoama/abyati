<?php

namespace App\Datatables\Admin\Reports;

use App\Datatables\Datatable;
use App\Models\OrderExecution;
use Illuminate\Database\Eloquent\Builder;

class EmployeePerformanceIndex extends Datatable
{
    /**
     * @return Builder|mixed
     */
    public function query()
    {
        if (empty(request('employee_id'))) {
            return OrderExecution::query()
                ->whereNull('employee_id');
        }

        return OrderExecution::query()
            ->filter()
            ->with([
                'order' => fn($q) => $q->select('id', 'reference_id', 'employee_id'),
            ]);
    }

    /**
     * For adding column to datatable
     */
    protected function addColumns(): array
    {
        return [
            'duration' => function (OrderExecution $execution) {
                return view('admin.pages.reports.employee-performance.partials.cols.duration', compact('execution'));
            },
            'action' => function (OrderExecution $execution) {
                return view('admin.pages.reports.employee-performance.partials.cols.actions', compact('execution'));
            },
        ];
    }

    /**
     * For edit column in the datatable
     */
    public function editColumns(): array
    {
        return [
            'reference_id' => function (OrderExecution $execution) {
                return view('admin.pages.reports.employee-performance.partials.cols.reference_id', compact('execution'));
            },
            'started_at' => function (OrderExecution $execution) {
                return view('admin.pages.reports.employee-performance.partials.cols.started_at', compact('execution'));
            },
            'completed_at' => function (OrderExecution $execution) {
                return view('admin.pages.reports.employee-performance.partials.cols.completed_at', compact('execution'));
            },
        ];
    }

    /**
     * For filtering columns in the datatable
     */
    protected function filterColumns(): array
    {
        return [
            //
        ];
    }
}
