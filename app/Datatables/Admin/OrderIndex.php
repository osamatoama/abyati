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
            ->filter()
            ->readyForProcessing()
            ->with([
                'store',
                'branch',
                'employee',
            ])
            ->withCount([
                'items' => fn($q) => $q->remote(),
            ]);
    }

    /**
     *
     * @return array
     */
    protected function addColumns(): array
    {
        return [
            'store' => function (Order $order) {
                return view('admin.pages.orders.partials.index.cols.store', compact('order'));
            },
            'branch' => function (Order $order) {
                return view('admin.pages.orders.partials.index.cols.branch', compact('order'));
            },
            'employee' => function (Order $order) {
                return view('admin.pages.orders.partials.index.cols.employee', compact('order'));
            },
            'total' => function (Order $order) {
                return view('admin.pages.orders.partials.index.cols.total', compact('order'));
            },
            'actions' => function (Order $order) {
                return view('admin.pages.orders.partials.index.cols.actions', compact('order'));
            },
        ];
    }

    /**
     * @return array
     */
    public function editColumns(): array
    {
        return [
            'reference_id' => function (Order $order) {
                return view('admin.pages.orders.partials.index.cols.reference_id', compact('order'));
            },
            'date' => function (Order $order) {
                return view('admin.pages.orders.partials.index.cols.date', compact('order'));
            },
            'status' => function (Order $order) {
                return view('admin.pages.orders.partials.index.cols.status', compact('order'));
            },
            'completion_status' => function (Order $order) {
                return view('admin.pages.orders.partials.index.cols.completion_status', compact('order'));
            },
            'customer' => function (Order $order) {
                return view('admin.pages.orders.partials.index.cols.customer', compact('order'));
            },
        ];
    }
}
