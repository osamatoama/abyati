<?php

namespace App\Datatables\Admin;

use App\Models\Shelf;
use App\Datatables\Datatable;
use Illuminate\Database\Eloquent\Builder;

class ShelfIndex extends Datatable
{
    /**
     * @return Builder|mixed
     */
    public function query()
    {
        return Shelf::query()
            ->filter()
            ->withCount([
                'products',
            ]);
    }

    /**
     * For adding column to datatable
     */
    protected function addColumns(): array
    {
        return [
            'warehouse' => function (Shelf $shelf) {
                return view('admin.pages.shelves.partials.index.cols.warehouse', compact('shelf'));
            },
            'action' => function (Shelf $shelf) {
                return view('admin.pages.shelves.partials.index.cols.actions', compact('shelf'));
            }
        ];
    }

    /**
     * For edit column in the datatable
     */
    public function editColumns(): array
    {
        return [
            'id' => function (Shelf $shelf) {
                return view('admin.pages.shelves.partials.index.cols.id', compact('shelf'));
            },
            'name' => function (Shelf $shelf) {
                return view('admin.pages.shelves.partials.index.cols.name', compact('shelf'));
            },
            'description' => function (Shelf $shelf) {
                return view('admin.pages.shelves.partials.index.cols.description', compact('shelf'));
            },
            'order' => function (Shelf $shelf) {
                return view('admin.pages.shelves.partials.index.cols.order', compact('shelf'));
            },
            'products_count' => function (Shelf $shelf) {
                return view('admin.pages.shelves.partials.index.cols.products_count', compact('shelf'));
            },
        ];
    }

    /**
     * For filtering columns in the datatable
     */
    protected function filterColumns(): array
    {
        return [
            'name' => function ($query, $keyword) {
                $query->where('name', '=', $keyword);
            },
        ];
    }
}
