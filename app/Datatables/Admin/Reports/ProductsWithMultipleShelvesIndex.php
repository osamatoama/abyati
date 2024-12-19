<?php

namespace App\Datatables\Admin\Reports;

use App\Models\Product;
use App\Models\Warehouse;
use App\Datatables\Datatable;
use Illuminate\Database\Eloquent\Builder;

class ProductsWithMultipleShelvesIndex extends Datatable
{
    /**
     * @return Builder|mixed
     */
    public function query()
    {
        if (empty(request('warehouse_id'))) {
            return Product::query()
                ->whereNull('id');
        }

        request()->merge([
            'branch_id' => request('warehouse_id')
                ? Warehouse::query()->find(request('warehouse_id'))?->branch_id
                : null,
        ]);

        return Product::query()
            ->select('id', 'remote_id', 'name', 'sku', 'main_image', 'status')
            ->with([
                'shelves' => fn($q) =>
                    $q->when(request('warehouse_id'), fn ($q) =>
                        $q->where('warehouse_id', request('warehouse_id'))
                    ),
                'quantities',
                'quantities.branch' => fn($q) => $q->active(),
            ])
            ->whereHas('shelves', fn ($q) =>
                    $q->when(request('warehouse_id'), fn ($q) =>
                        $q->where('warehouse_id', request('warehouse_id'))
                ), '>', 1
            )
            ->withSum(
                [
                    'quantities as sum_quantity' => fn ($q) =>
                        $q->when(request('branch_id'), fn ($q) =>
                            $q->where('branch_id', request('branch_id'))
                        )
                ],
                'quantity',
            );
    }

    /**
     * For adding column to datatable
     */
    protected function addColumns(): array
    {
        return [
            'image' => function (Product $product) {
                return view('admin.pages.reports.products-with-multiple-shelves.partials.cols.image', compact('product'));
            },
            'shelves' => function (Product $product) {
                return view('admin.pages.reports.products-with-multiple-shelves.partials.cols.shelves', compact('product'));
            },
            'quantities' => function (Product $product) {
                return view('admin.pages.reports.products-with-multiple-shelves.partials.cols.quantities', compact('product'));
            },
            'action' => function (Product $product) {
                return view('admin.pages.reports.products-with-multiple-shelves.partials.cols.actions', compact('product'));
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
                return view('admin.pages.reports.products-with-multiple-shelves.partials.cols.remote_id', compact('product'));
            },
            'name' => function (Product $product) {
                return view('admin.pages.reports.products-with-multiple-shelves.partials.cols.name', compact('product'));
            },
            'sku' => function (Product $product) {
                return view('admin.pages.reports.products-with-multiple-shelves.partials.cols.sku', compact('product'));
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
