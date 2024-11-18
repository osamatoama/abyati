<?php

namespace App\Datatables\Admin;

use App\Models\Product;
use App\Datatables\Datatable;
use Illuminate\Database\Eloquent\Builder;

class ProductIndex extends Datatable
{
    /**
     * @return Builder|mixed
     */
    public function query()
    {
        return Product::query()
            ->filter()
            ->with([
                'store' => fn($q) => $q->select('id', 'name'),
                'shelves' => fn($q) => $q->select('shelves.id', 'shelves.warehouse_id', 'shelves.name'),
                'shelves.warehouse' => fn($q) => $q->select('id', 'name'),
            ]);
    }

    /**
     * For adding column to datatable
     */
    protected function addColumns(): array
    {
        return [
            'store' => function (Product $product) {
                return view('admin.pages.products.partials.index.cols.store', compact('product'));
            },
            'warehouse' => function (Product $product) {
                return view('admin.pages.products.partials.index.cols.warehouse', compact('product'));
            },
            'image' => function (Product $product) {
                return view('admin.pages.products.partials.index.cols.image', compact('product'));
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
                return view('admin.pages.products.partials.index.cols.id', compact('product'));
            },
            'remote_id' => function (Product $product) {
                return view('admin.pages.products.partials.index.cols.remote_id', compact('product'));
            },
            'name' => function (Product $product) {
                return view('admin.pages.products.partials.index.cols.name', compact('product'));
            },
            'sku' => function (Product $product) {
                return view('admin.pages.products.partials.index.cols.sku', compact('product'));
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
