<?php

namespace App\Services\Orders\Fulfillment\Employee;

use App\Models\Order;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use App\Enums\OrderCompletionStatus;
use App\Enums\OrderItemCompletionStatus;

class ResetOrder
{
    public ?Employee $employee = null;

    public function __construct(
        public Order $order,
    )
    {
        $this->employee = auth('employee')->user();
    }

    public function execute()
    {
        DB::transaction(function () {
            $this->order->update([
                'completion_status' => OrderCompletionStatus::PENDING,
                'employee_id' => null,
            ]);

            foreach ($this->order->items as $item) {
                $item->update([
                    'completion_status' => OrderItemCompletionStatus::PENDING,
                    'executed_quantity' => 0,
                    'issue_quantity' => 0,
                ]);
            }
        });

        $this->dispatchEvents();
    }

    private function dispatchEvents()
    {
        //
    }
}
