<?php

namespace App\Http\Controllers\Employee;

use App\Models\Order;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Employee\OrdersExport;
use App\Datatables\Employee\OrderIndex;
use App\Enums\OrderCompletionStatus;
use App\Http\Controllers\Concerns\Authorizable;
use App\Http\Requests\Employee\Order\AssignRequest;
use Throwable;

class OrderController extends Controller
{
    use Authorizable;

    protected $permissionName = 'orders';

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
                'title' => __('employee.orders.details'),
                'html' => view('employee.pages.orders.partials.index.order-details', compact('order'))->render(),
            ],
        ]);
    }

    public function assign(AssignRequest $request, Order $order)
    {
        try {
            $order->assignTo($request->employee_id);

            $order->executionHistories()->create([
                'employee_id' => $request->employee_id,
                'status' => OrderCompletionStatus::PROCESSING,
            ]);
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

    public function process(Order $order)
    {
        abort_unless($order->isAssignedToMe(), 403, __('employee.orders.errors.cannot_process'));

        return view('employee.pages.orders.process', compact('order'));
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
