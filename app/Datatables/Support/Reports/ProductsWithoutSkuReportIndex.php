<?php

namespace App\Datatables\Support\Reports;

use App\Models\Product;
use App\Datatables\Datatable;
use Illuminate\Database\Eloquent\Builder;

class ProductsWithoutSkuReportIndex extends Datatable
{
    /**
     * @return Builder|mixed
     */
    public function query()
    {
        return Product::query()
            ->whereNull('sku');
    }

    /**
     * For adding column to datatable
     */
    protected function addColumns(): array
    {
        return [
            'store' => function (Product $product) {
                return view('support.pages.reports.products-without-sku.partials.cols.store', compact('product'));
            },
            'image' => function (Product $product) {
                return view('support.pages.reports.products-without-sku.partials.cols.image', compact('product'));
            },
        ];
    }

    /**
     * For edit column in the datatable
     */
    public function editColumns(): array
    {
        return [
            'id' => function (Product $product) {
                return view('support.pages.reports.products-without-sku.partials.cols.id', compact('product'));
            },
            'remote_id' => function (Product $product) {
                return view('support.pages.reports.products-without-sku.partials.cols.remote_id', compact('product'));
            },
            'name' => function (Product $product) {
                return view('support.pages.reports.products-without-sku.partials.cols.name', compact('product'));
            },
            'sku' => function (Product $product) {
                return view('support.pages.reports.products-without-sku.partials.cols.sku', compact('product'));
            },
        ];
    }

    /**
     * For filtering columns in the datatable
     */
    protected function filterColumns(): array
    {
        return [
            'remote_id' => function ($query, $keyword) {
                $query->where('remote_id', 'LIKE', "%$keyword%");
            },
        ];
    }
}
