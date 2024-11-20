<?php

namespace App\Http\Controllers\Employee;

use Throwable;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Employee\OrdersExport;
use App\Datatables\Employee\OrderIndex;
use App\Http\Requests\Employee\Order\AssignRequest;
use App\Http\Requests\Employee\Order\UnassignRequest;
use App\Services\Orders\Fulfillment\Employee\ResetOrder;
use App\Services\Orders\Fulfillment\Employee\AssignOrderToMe;
use App\Services\Orders\Fulfillment\Employee\UnassignOrderFromMe;

class OrderController extends Controller
{
    public function index(): mixed
    {
        if (request()->ajax() or request()->expectsJson()) {
            return app(OrderIndex::class)->render();
        }

        return view('employee.pages.orders.index');
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
                'title' => __('employee.orders.details'),
                'html' => view('employee.pages.orders.partials.index.order-details', compact('order'))->render(),
            ],
        ]);
    }

    public function assign(AssignRequest $request, Order $order)
    {
        try {
            (new AssignOrderToMe(
                order: $order,
            ))->execute();

        } catch (Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => __('globals.errors.something_went_wrong'),
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => __('employee.orders.messages.assigned'),
            'data' => [],
        ]);
    }

    public function unassign(UnassignRequest $request, Order $order)
    {
        try {
            DB::transaction(function () use ($order) {
                (new UnassignOrderFromMe(
                    order: $order,
                ))->execute();
            });
        } catch (Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => __('globals.errors.something_went_wrong'),
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => __('employee.orders.messages.unassigned'),
            'data' => [],
        ]);
    }

    public function process(Order $order)
    {
        abort_unless($order->isBranchMine() && $order->isAssignedToMe(), 403, __('employee.orders.errors.cannot_process'));

        $order->load([
            'items',
            'items.product',
            'items.product.shelves' => fn($q) => $q->where('warehouse_id', $order->warehouse_id),
        ]);

        return view('employee.pages.orders.process', compact('order'));
    }

    public function reset(Request $request, Order $order)
    {
        abort_unless(auth('employee')->user()->canAccessAllOrders(), 403);

        try {
            DB::transaction(function () use ($order) {
                (new ResetOrder(
                    order: $order,
                ))->execute();
            });
        } catch (Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => __('globals.errors.something_went_wrong'),
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => __('employee.orders.messages.reset'),
            'data' => [],
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
    //         'message' => __('employee.orders.messages.pull_started'),
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
    //             'title' => __('employee.orders.history.title') . ' #' . $order->reference_id,
    //             'html' => view('employee.pages.orders.partials.index.histories', compact('histories'))->render(),
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
