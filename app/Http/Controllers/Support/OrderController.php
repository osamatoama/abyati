<?php

namespace App\Http\Controllers\Support;

use Throwable;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use App\Enums\OrderCompletionStatus;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Support\OrdersExport;
use App\Datatables\Support\OrderIndex;
use App\Events\Order\OrderAssignedEvent;
use App\Events\Order\OrderUnassignedEvent;
use App\Http\Requests\Support\Order\AssignRequest;
use App\Http\Requests\Support\Order\UnassignRequest;

class OrderController extends Controller
{
    public function index(): mixed
    {
        if (request()->ajax() or request()->expectsJson()) {
            return app(OrderIndex::class)->render();
        }

        return view('support.pages.orders.index');
    }

    public function show(Order $order)
    {
        $order->load([
            'items.product' => function ($query) {
                $query->select('id', 'name', 'sku', 'main_image');
            },
            'items.variant' => function ($query) {
                $query->select('id', 'sku', 'barcode');
            },
            'items.variant.optionValues.option',
            // 'histories' => fn($q) => $q->orderBy('date'),
            // 'histories.status' => fn($q) => $q->select('id', 'name'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'fetched successfully',
            'data' => [
                'title' => __('support.orders.details'),
                'html' => view('support.pages.orders.partials.index.order-details', compact('order'))->render(),
            ],
        ]);
    }

    public function process(Order $order)
    {
        // abort_unless($order->isBranchMine() && $order->isAssignedToMe(), 403, __('support.orders.errors.cannot_process'));

        return view('support.pages.orders.process', compact('order'));
    }

    public function export()
    {
        return Excel::download(
            export: new OrdersExport(
                query: app(OrderIndex::class)->query()
            ),
            fileName: getExcelFileName('orders'),
        );
    }
}
