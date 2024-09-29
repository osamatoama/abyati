<?php

namespace App\Services\Orders\Fulfillment\Employee;

use App\Models\Order;
use Illuminate\Support\Facades\DB;

class SyncOrderExecutionStatusWithItems
{
    public function __construct(
        public Order $order,
    )
    {
        $this->order->refresh()->load('items');
    }

    public function execute()
    {
        if ($this->order->isExecuted()) {
            DB::transaction(function () {
                $this->order->setAsCompleted();

                $this->order->logCompletedToHistory();
            });

            return;
        }

        $this->dispatchEvents();
    }

    private function dispatchEvents()
    {
        // event(new OrderAssignedEvent(
        //     order: $this->order,
        //     selfAssign: true,
        // ));
    }
}
