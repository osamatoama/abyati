<?php

namespace App\Datatables\Admin;

use App\Models\Support;
use App\Datatables\Datatable;

class SupportIndex extends Datatable
{
    public function query()
    {
        return Support::query();
    }


    /**
     *
     * @return array
     */
    protected function addColumns()
    {
        return [
            'action' => function (Support $support) {
                return view('admin.pages.supports.partials.index.cols.actions', compact('support'));
            },
        ];
    }

    /**
     * @return array
     */
    public function editColumns()
    {
        return [
            'phone' => function (Support $support) {
                return view('admin.pages.supports.partials.index.cols.phone', compact('support'));
            },
            'active' => function (Support $support) {
                return view('admin.pages.supports.partials.index.cols.active', compact('support'));
            },
        ];
    }
}
