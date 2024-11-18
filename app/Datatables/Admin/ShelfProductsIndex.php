<?php

namespace App\Datatables\Admin;

use App\Models\Shelf;
use App\Models\Product;
use App\Datatables\Datatable;
use Illuminate\Database\Eloquent\Builder;

class ShelfProductsIndex extends Datatable
{
    public function __construct(
        private Shelf $shelf,
    )
    {
        //
    }

    /**
     * @return Builder|mixed
     */
    public function query()
    {
        return Product::query()
            ->whereHas('shelves', function ($query) {
                $query->where('shelves.id', $this->shelf->id);
            });
    }

    /**
     * For adding column to datatable
     */
    protected function addColumns(): array
    {
        return [
            'image' => function (Product $product) {
                return view('admin.pages.shelves.partials.show.cols.image', compact('product'));
            },
            'action' => function (Product $product) {
                $shelf = $this->shelf;
                return view('admin.pages.shelves.partials.show.cols.actions', compact('product', 'shelf'));
            }
        ];
    }

    /**
     * For edit column in the datatable
     */
    public function editColumns(): array
    {
        return [
            'id' => function (Product $product) {
                return view('admin.pages.shelves.partials.show.cols.id', compact('product'));
            },
            'remote_id' => function (Product $product) {
                return view('admin.pages.shelves.partials.show.cols.remote_id', compact('product'));
            },
            'name' => function (Product $product) {
                return view('admin.pages.shelves.partials.show.cols.name', compact('product'));
            },
            'sku' => function (Product $product) {
                return view('admin.pages.shelves.partials.show.cols.sku', compact('product'));
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
