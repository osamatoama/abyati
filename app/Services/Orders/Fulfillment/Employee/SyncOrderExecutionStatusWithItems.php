<?php

namespace App\Services\Orders\Fulfillment\Employee;

use App\Models\Order;
use App\Models\Employee;
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

                $this->order->logCompletedToHistory(
                    executorType: Employee::class,
                    executorId: $this->order->employee_id,
                );

                $this->order->executions()->where('employee_id', $this->order->employee_id)->update([
                    'completed' => true,
                    'completed_at' => now(),
                ]);
            });

            return;
        }

        $this->dispatchEvents();
    }

    private function dispatchEvents()
    {
        //
    }
}
