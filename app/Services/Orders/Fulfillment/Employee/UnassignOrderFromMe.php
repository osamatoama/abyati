<?php

namespace App\Services\Orders\Fulfillment\Employee;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use App\Events\Order\OrderUnassignedEvent;

class UnassignOrderFromMe
{
    public int $employeeId;

    public function __construct(
        public Order $order,
    )
    {
        $this->employeeId = auth('employee')->id();
    }

    public function execute()
    {
        DB::transaction(function () {
            $this->order->unassign();

            $this->order->executions()->where('employee_id', $this->employeeId)->update([
                'unassigned_at' => now(),
            ]);
        });

        $this->dispatchEvents();
    }

    private function dispatchEvents()
    {
        event(new OrderUnassignedEvent(
            order: $this->order,
        ));
    }
}
