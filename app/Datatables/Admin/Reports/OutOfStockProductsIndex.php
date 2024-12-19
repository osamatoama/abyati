<?php

namespace App\Datatables\Admin\Reports;

use App\Models\Product;
use App\Models\Warehouse;
use App\Datatables\Datatable;
use Illuminate\Database\Eloquent\Builder;

class OutOfStockProductsIndex extends Datatable
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
                // 'quantities' => fn($q) =>
                //     $q->whereNotNull('expiry_date')
                //         ->whereDate('expiry_date', '<=', $expiryDateThreshold)
                //         ->when(request('branch_id'), fn ($q) =>
                //             $q->where('branch_id', request('branch_id')
                //         )
                // ),
                // 'quantities.branch' => fn($q) => $q->active(),
            ])
            ->whereHas('shelves', fn($q) =>
                $q->when(request('warehouse_id'), fn ($q) =>
                        $q->where('warehouse_id', request('warehouse_id'))
                    )
                    ->when(request('employee_id'), fn ($q) =>
                        $q->whereHas('employees', fn ($q) =>
                            $q->where('employees.id', request('employee_id'))
                        )
                    )
            )
            ->whereHas('quantities', fn ($q) =>
                $q->where('quantity', '<=', 0)
                    ->when(request('branch_id'), fn ($q) =>
                        $q->where('branch_id', request('branch_id')
                    )
            ));
    }

    /**
     * For adding column to datatable
     */
    protected function addColumns(): array
    {
        return [
            'image' => function (Product $product) {
                return view('admin.pages.reports.out-of-stock-products.partials.cols.image', compact('product'));
            },
            'shelves' => function (Product $product) {
                return view('admin.pages.reports.out-of-stock-products.partials.cols.shelves', compact('product'));
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
                return view('admin.pages.reports.out-of-stock-products.partials.cols.remote_id', compact('product'));
            },
            'name' => function (Product $product) {
                return view('admin.pages.reports.out-of-stock-products.partials.cols.name', compact('product'));
            },
            'sku' => function (Product $product) {
                return view('admin.pages.reports.out-of-stock-products.partials.cols.sku', compact('product'));
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
