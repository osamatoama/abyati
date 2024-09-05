<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\OrderStatus;
use App\Http\Controllers\Controller;
use App\Datatables\Client\OrderIndex;
use App\Http\Controllers\Concerns\Authorizable;
use App\Http\Requests\Admin\SetupPullOrdersRequest;
use App\Jobs\Salla\Pull\Orders\SallaPullOrdersWithLimitJob;

class OrderController extends Controller
{
    use Authorizable;

    protected $permissionName = 'orders';

    public function index(): mixed
    {
        if (request()->ajax() or request()->expectsJson()) {
            return app(OrderIndex::class)->render();
        }

        $statuses = OrderStatus::mine()->get();
        $statusesForUpdate = $statuses->where('source', 'salla');

        return view('client.orders.index', compact('statuses', 'statusesForUpdate'));
    }

    public function show(Order $order)
    {
        $order->load([
            'customer',
            'address',
            'items.product' => function ($query) {
                $query->select('id', 'name', 'main_image');
            },
            'items.variant' => function ($query) {
                $query->select('id');
            },
            'items.variant.optionValues.option',
            'histories' => fn($q) => $q->orderBy('date'),
            'histories.status' => fn($q) => $q->select('id', 'name'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'fetched successfully',
            'data' => [
                'title' => __('orders.details'),
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
    //         'message' => __('orders.messages.pull_started'),
    //         'data' => [],
    //     ]);
    // }

    public function histories(Order $order)
    {
        $histories = $order->histories()->orderBy('date')->get();

        return response()->json([
            'success' => true,
            'message' => 'fetched successfully',
            'data' => [
                'title' => __('orders.history.title') . ' #' . $order->reference_id,
                'html' => view('admin.pages.orders.partials.index.histories', compact('histories'))->render(),
            ],
        ]);
    }
}