<?php

namespace App\Datatables\Admin;

use App\Models\Employee;
use App\Datatables\Datatable;

class EmployeeIndex extends Datatable
{
    public function query()
    {
        return Employee::query()
            ->with([
                'branch' => fn($q) => $q->select('id', 'name'),
            ]);
    }


    /**
     *
     * @return array
     */
    protected function addColumns()
    {
        return [
            'action' => function (Employee $employee) {
                return view('admin.pages.employees.partials.index.cols.actions', compact('employee'));
            },
        ];
    }

    /**
     * @return array
     */
    public function editColumns()
    {
        return [
            'branch' => function (Employee $employee) {
                return view('admin.pages.employees.partials.index.cols.branch', compact('employee'));
            },
            'phone' => function (Employee $employee) {
                return view('admin.pages.employees.partials.index.cols.phone', compact('employee'));
            },
            'roles' => function (Employee $employee) {
                return view('admin.pages.employees.partials.index.cols.roles', compact('employee'));
            },
            'active' => function (Employee $employee) {
                return view('admin.pages.employees.partials.index.cols.active', compact('employee'));
            },
        ];
    }
}
