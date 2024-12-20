<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Exports\Admin\OrdersExport;
use App\Datatables\Admin\OrderIndex;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Concerns\Authorizable;

class OrderController extends Controller
{
    use Authorizable;

    protected $permissionName = 'orders';

    protected $additionalAbilities = [
        'export' => 'export',
    ];

    public function index(): mixed
    {
        if (request()->ajax() or request()->expectsJson()) {
            return app(OrderIndex::class)->render();
        }

        return view('admin.pages.orders.index');
    }

    public function show(Order $order)
    {
        $order->load([
            'items' => fn ($q) => $q->remote()->withTrashed(),
            'items.product' => fn ($q) => $q->select('id', 'name', 'sku', 'main_image'),
            'items.variant' => fn ($q) => $q->select('id', 'sku', 'barcode'),
            'items.variant.optionValues.option',
            // 'histories' => fn($q) => $q->orderBy('date'),
            // 'histories.status' => fn($q) => $q->select('id', 'name'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'fetched successfully',
            'data' => [
                'title' => __('admin.orders.details'),
                'html' => view('admin.pages.orders.partials.index.order-details', compact('order'))->render(),
            ],
        ]);
    }

    // public function setupPull(SetupPullOrdersRequest $request)
    // {
    //     $data = $request->validated();

    //     dispatch(new SallaPullOrdersWithLimitJob(
    //         user: currentUser(),
    //         limit: $data['orders_count'],
    //         filters: ['to_date' => $data['to_date']],
    //     ));

    //     currentUser()->installation?->markModuleAsPulled('orders');

    //     return response()->json([
    //         'success' => true,
    //         'message' => __('admin.orders.messages.pull_started'),
    //         'data' => [],
    //     ]);
    // }

    // public function histories(Order $order)
    // {
    //     $histories = $order->histories()->orderBy('date')->get();

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'fetched successfully',
    //         'data' => [
    //             'title' => __('admin.orders.history.title') . ' #' . $order->reference_id,
    //             'html' => view('admin.pages.orders.partials.index.histories', compact('histories'))->render(),
    //         ],
    //     ]);
    // }

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
