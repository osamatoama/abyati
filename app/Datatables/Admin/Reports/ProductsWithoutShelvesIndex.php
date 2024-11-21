<?php

namespace App\Datatables\Admin\Reports;

use App\Models\Product;
use App\Datatables\Datatable;
use Illuminate\Database\Eloquent\Builder;

class ProductsWithoutShelvesIndex extends Datatable
{
    /**
     * @return Builder|mixed
     */
    public function query()
    {
        return Product::query()
            ->select('id', 'remote_id', 'name', 'sku', 'main_image', 'status')
            ->doesntHave('shelves');
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
