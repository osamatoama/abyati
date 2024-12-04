<?php

namespace App\Datatables\Admin\Reports;

use App\Models\Product;
use App\Models\Warehouse;
use App\Datatables\Datatable;
use Illuminate\Database\Eloquent\Builder;

class ProductsWithoutShelvesIndex extends Datatable
{
    /**
     * @return Builder|mixed
     */
    public function query()
    {
        request()->merge([
            'branch_id' => request('warehouse_id')
                ? Warehouse::query()->find(request('warehouse_id'))?->branch_id
                : null,
        ]);

        return Product::query()
            ->select('id', 'remote_id', 'name', 'sku', 'main_image', 'status')
            ->with([
                'quantities',
                'quantities.branch' => fn($q) => $q->active(),
            ])
            ->whereDoesntHave('shelves', fn ($query) =>
                $query->when(request('warehouse_id'), fn ($q) =>
                    $q->where('warehouse_id', request('warehouse_id'))
                )
            )
            ->whereHas('quantities', fn ($query) =>
                $query->where('quantity', '>', 0)
                    ->when(request('branch_id'), fn ($q) =>
                        $q->where('branch_id', request('branch_id'))
                    )
            );
    }

    /**
     * For adding column to datatable
     */
    protected function addColumns(): array
    {
        return [
            'image' => function (Product $product) {
                return view('admin.pages.reports.products-without-shelves.partials.cols.image', compact('product'));
            },
            'quantities' => function (Product $product) {
                return view('admin.pages.reports.products-without-shelves.partials.cols.quantities', compact('product'));
            },
            'action' => function (Product $product) {
                return view('admin.pages.reports.products-without-shelves.partials.cols.actions', compact('product'));
            },
        ];
    }

    /**
     * For edit column in the datatable
     */
    public function editColumns(): array
    {
        return [
            'remote_id' => function (Product $product) {
                return view('admin.pages.reports.products-without-shelves.partials.cols.remote_id', compact('product'));
            },
            'name' => function (Product $product) {
                return view('admin.pages.reports.products-without-shelves.partials.cols.name', compact('product'));
            },
            'sku' => function (Product $product) {
                return view('admin.pages.reports.products-without-shelves.partials.cols.sku', compact('product'));
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
