<?php

namespace App\Services\Orders\Fulfillment\Employee;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use App\Events\Order\OrderAssignedEvent;

class AssignOrderToMe
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
            $this->order->assignTo($this->employeeId);

            if ($this->order->isPending()) {
                $this->order->setAsProcessing();
            }

            $this->order->logProcessingToHistory($this->employeeId);

            $this->order->executions()->create([
                'employee_id' => $this->employeeId,
                'started_at' => now(),
            ]);
        });

        $this->dispatchEvents();
    }

    private function dispatchEvents()
    {
        event(new OrderAssignedEvent(
            order: $this->order,
            selfAssign: true,
        ));
    }
}