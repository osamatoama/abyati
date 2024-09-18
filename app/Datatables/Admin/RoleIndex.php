<?php

namespace App\Datatables\Admin;

use App\Models\Role;
use App\Datatables\Datatable;
use Illuminate\Database\Eloquent\Builder;

class RoleIndex extends Datatable
{
    /**
     * @return Builder|mixed
     */
    public function query()
    {
        return Role::query();
    }


    /**
     *
     * @return array
     */
    protected function addColumns()
    {
        return [
            'name' => function ($role) {
                return view('admin.pages.roles.partials.index.cols.name', compact('role'));
            },
            'action' => function ($role) {
                return view('admin.pages.roles.partials.index.cols.actions', compact('role'));
            }
        ];
    }

    /**
     * @return array
     */
    public function editColumns()
    {
        return [
            //
        ];
    }
}
