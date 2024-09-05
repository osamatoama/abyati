<?php

namespace App\Datatables\Admin;

use App\Models\Order;
use App\Datatables\Datatable;
use Illuminate\Database\Eloquent\Builder;

class OrderIndex extends Datatable
{
    /**
     * @return Builder|mixed
     */
    public function query()
    {
        return Order::query()
            ->mine()
            ->filter()
            ->with([
                'customer' => fn($q) => $q->select('id', 'first_name', 'last_name'),
            ])
            ->withCount([
                'items'
            ]);
    }


    /**
     *
     * @return array
     */
    protected function addColumns(): array
    {
        return [
            'actions' => function ($order) {
                return view('admin.pages.orders.partials.index.cols.actions', compact('order'));
            },
            'customer' => function ($order) {
                return view('admin.pages.orders.partials.index.cols.customer', compact('order'));
            },
        ];
    }

    /**
     * @return array
     */
    public function editColumns(): array
    {
        return [
            'reference_id' => function ($order) {
                return view('admin.pages.orders.partials.index.cols.reference_id', compact('order'));
            },
            'date' => function ($order) {
                return view('admin.pages.orders.partials.index.cols.date', compact('order'));
            },
            'status' => function ($order) {
                return view('admin.pages.orders.partials.index.cols.status', compact('order'));
            },
            'payment_method' => function ($order) {
                return view('admin.pages.orders.partials.index.cols.payment_method', compact('order'));
            },
        ];
    }
}
