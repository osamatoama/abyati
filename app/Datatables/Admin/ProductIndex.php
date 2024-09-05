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
        return Product::query()->mine();
    }

    /**
     * For adding column to datatable
     */
    protected function addColumns(): array
    {
        return [
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
            'salla_id' => function (Product $product) {
                return view('admin.pages.products.partials.index.cols.salla-id', compact('product'));
            },
            'name' => function (Product $product) {
                return view('admin.pages.products.partials.index.cols.name', compact('product'));
            },
            'sku' => function (Product $product) {
                return view('admin.pages.products.partials.index.cols.sku', compact('product'));
            },
            'quantity' => function (Product $product) {
                return view('admin.pages.products.partials.index.cols.quantity', compact('product'));
            },
            'price' => function (Product $product) {
                return view('admin.pages.products.partials.index.cols.price', compact('product'));
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
