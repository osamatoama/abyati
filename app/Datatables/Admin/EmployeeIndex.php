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
                'roles'
            ])
            ->mine();
    }


    /**
     *
     * @return array
     */
    protected function addColumns()
    {
        return [
            'action' => function ($data) {
                return view('client.employees.partials.index.cols.actions', compact('data'));
            },
            'role' => function ($data) {
                return $data->roles->first()->{"name_" . locale()->current()};
            },

        ];
    }

    /**
     * @return array
     */
    public function editColumns()
    {
        return [
            'phone' => function ($data) {
                return view('client.employees.partials.index.cols.phone', compact('data'));
            },
            'active' => function ($data) {
                return view('client.employees.partials.index.cols.active', compact('data'));
            },
        ];
    }
}
