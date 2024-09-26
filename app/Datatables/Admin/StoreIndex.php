<?php

namespace App\Datatables\Admin;

use App\Models\Store;
use App\Datatables\Datatable;
use Illuminate\Database\Eloquent\Builder;

class StoreIndex extends Datatable
{
    /**
     * @return Builder|mixed
     */
    public function query()
    {
        return Store::query();
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
            'name' => function (Store $store) {
                return view('admin.pages.stores.partials.index.cols.name', compact('store'));
            },
            'domain' => function (Store $store) {
                return view('admin.pages.stores.partials.index.cols.domain', compact('store'));
            },
            'id_color' => function (Store $store) {
                return view('admin.pages.stores.partials.index.cols.id_color', compact('store'));
            },
            // 'active' => function (Store $store) {
            //     return view('admin.pages.stores.partials.index.cols.active', compact('store'));
            // },
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
