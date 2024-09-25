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
                $query->select('id', 'name', 'main_image');
            },
            'items.variant' => function ($query) {
                $query->select('id');
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

    public function assign(AssignRequest $request, Order $order)
    {
        /**
         * TODO: REPLICATED CODE
         */

        try {
            DB::transaction(function () use ($request, $order) {
                $order->assignTo($request->support_id);

                $order->executionHistories()->create([
                    'support_id' => $request->support_id,
                    'status' => OrderCompletionStatus::PROCESSING,
                ]);

                event(new OrderAssignedEvent(
                    order: $order,
                    selfAssign: true,
                ));
            });
        } catch (Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => __('globals.errors.something_went_wrong'),
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => __('support.orders.messages.assigned'),
            'data' => [],
        ]);
    }

    public function unassign(UnassignRequest $request, Order $order)
    {
        /**
         * TODO: REPLICATED CODE
         */

        try {
            DB::transaction(function () use ($order) {
                $order->unassign();

                event(new OrderUnassignedEvent(
                    order: $order,
                ));
            });
        } catch (Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => __('globals.errors.something_went_wrong'),
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => __('support.orders.messages.unassigned'),
            'data' => [],
        ]);
    }

    public function process(Order $order)
    {
        abort_unless($order->isBranchMine() && $order->isAssignedToMe(), 403, __('support.orders.errors.cannot_process'));

        return view('support.pages.orders.process', compact('order'));
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
    //         'message' => __('support.orders.messages.pull_started'),
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
    //             'title' => __('support.orders.history.title') . ' #' . $order->reference_id,
    //             'html' => view('support.pages.orders.partials.index.histories', compact('histories'))->render(),
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
