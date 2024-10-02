<?php

namespace App\Datatables\Admin\Reports;

use App\Models\Product;
use App\Datatables\Datatable;
use App\Enums\OrderItemCompletionStatus;
use Illuminate\Database\Eloquent\Builder;

class QuantityIssuesIndex extends Datatable
{
    /**
     * @return Builder|mixed
     */
    public function query()
    {
        return Product::query()
            ->whereHas('orderItems', function($q) {
                return $q->whereIn('completion_status', [OrderItemCompletionStatus::QUANTITY_ISSUES, OrderItemCompletionStatus::COMPLETED])
                    ->whereColumn('quantity', '>', 'executed_quantity');
            })
            ->with([
                'orderItems' => fn($q) => $q->whereIn('completion_status', [OrderItemCompletionStatus::QUANTITY_ISSUES, OrderItemCompletionStatus::COMPLETED])
                    ->whereColumn('quantity', '>', 'executed_quantity'),
            ]);
    }

    /**
     * For adding column to datatable
     */
    protected function addColumns(): array
    {
        return [
            'issues_count' => function (Product $product) {
                return view('admin.pages.reports.quantity-issues.partials.cols.issues_count', compact('product'));
            },
            'action' => function (Product $product) {
                return view('admin.pages.reports.quantity-issues.partials.cols.actions', compact('product'));
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
                return view('admin.pages.reports.quantity-issues.partials.cols.remote_id', compact('product'));
            },
            'name' => function (Product $product) {
                return view('admin.pages.reports.quantity-issues.partials.cols.name', compact('product'));
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
