<?php

namespace App\Datatables\Admin;

use App\Models\Branch;
use App\Datatables\Datatable;
use Illuminate\Database\Eloquent\Builder;

class BranchIndex extends Datatable
{
    /**
     * @return Builder|mixed
     */
    public function query()
    {
        return Branch::query();
    }

    /**
     * For adding column to datatable
     */
    protected function addColumns(): array
    {
        return [
            //
        ];
    }

    /**
     * For edit column in the datatable
     */
    public function editColumns(): array
    {
        return [
            'id' => function (Branch $branch) {
                return view('admin.pages.branches.partials.index.cols.id', compact('branch'));
            },
            'name' => function (Branch $branch) {
                return view('admin.pages.branches.partials.index.cols.name', compact('branch'));
            },
            'related_order_status_id' => function (Branch $branch) {
                return view('admin.pages.branches.partials.index.cols.related_order_status_id', compact('branch'));
            },
            'active' => function (Branch $branch) {
                return view('admin.pages.branches.partials.index.cols.active', compact('branch'));
            },
        ];
    }

    /**
     * For filtering columns in the datatable
     */
    protected function filterColumns(): array
    {
        return [
            'salla_id' => function ($query, $keyword) {
                $query->where('remote_id', 'LIKE', "%$keyword%");
            },
        ];
    }
}
