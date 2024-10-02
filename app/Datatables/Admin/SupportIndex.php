<?php

namespace App\Datatables\Admin;

use App\Models\Support;
use App\Datatables\Datatable;

class SupportIndex extends Datatable
{
    public function query()
    {
        return Support::query()
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
            'branch' => function (Support $support) {
                return view('admin.pages.supports.partials.index.cols.branch', compact('support'));
            },
            'phone' => function (Support $support) {
                return view('admin.pages.supports.partials.index.cols.phone', compact('support'));
            },
            'active' => function (Support $support) {
                return view('admin.pages.supports.partials.index.cols.active', compact('support'));
            },
        ];
    }
}
