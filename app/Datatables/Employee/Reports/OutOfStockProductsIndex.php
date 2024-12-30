<?php

namespace App\Datatables\Employee\Reports;

use App\Models\Product;
use App\Datatables\Datatable;
use Illuminate\Database\Eloquent\Builder;

class OutOfStockProductsIndex extends Datatable
{
    /**
     * @return Builder|mixed
     */
    public function query()
    {
        $employee = auth('employee')->user();
        $branch = $employee->branch;
        $warehouse = $branch?->warehouse;

        request()->merge([
            'employee_id' => $employee->id,
            'warehouse_id' => $warehouse?->id,
            'branch_id' => $branch?->id,
        ]);

        logger()->debug('Request', [
            'employee_id' => request('employee_id'),
            'warehouse_id' => request('warehouse_id'),
            'branch_id' => request('branch_id'),
            'aisle' => request('aisle'),
            'shelf_id' => request('shelf_id'),
        ]);

        return Product::query()
            ->select('id', 'remote_id', 'name', 'sku', 'main_image', 'status')
            ->with([
                'shelves' => fn($q) =>
                    $q->when(request('employee_id'), fn ($q) =>
                            $q->whereHas('employees', fn ($q) =>
                                $q->where('employees.id', request('employee_id'))
                            )
                        )
                        ->when('warehouse_id', fn ($q) =>
                            $q->where('warehouse_id', request('warehouse_id'))
                        )
                        ->when(request('aisle'), fn ($q) =>
                            $q->where('aisle', request('aisle'))
                        )
                        ->when(request('shelf_id'), fn ($q) =>
                            $q->where('shelves.id', request('shelf_id'))
                        )
            ])
            ->whereHas('shelves', fn($q) =>
                $q->when(request('employee_id'), fn ($q) =>
                        $q->whereHas('employees', fn ($q) =>
                            $q->where('employees.id', request('employee_id'))
                        )
                    )
                    ->when('warehouse_id', fn ($q) =>
                        $q->where('warehouse_id', request('warehouse_id'))
                    )
                    ->when(request('aisle'), fn ($q) =>
                        $q->where('aisle', request('aisle'))
                    )
                    ->when(request('shelf_id'), fn ($q) =>
                        $q->where('shelves.id', request('shelf_id'))
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
