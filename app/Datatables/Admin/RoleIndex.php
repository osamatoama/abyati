<?php

namespace App\Datatables\Admin;

use App\Datatables\Datatable;
use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class RoleIndex
 * @package App\Datatables\Client
 */
class RoleIndex extends Datatable
{
    /**
     * @return Builder|mixed
     */
    public function query()
    {
        return Role::query()
            ->mine();
    }


    /**
     *
     * @return array
     */
    protected function addColumns()
    {
        return [
            'name' => function ($role) {
                return view('client.roles.partials.index.cols.name', compact('role'));
            },
            'action' => function ($role) {
                return view('client.roles.partials.index.cols.actions', compact('role'));
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
