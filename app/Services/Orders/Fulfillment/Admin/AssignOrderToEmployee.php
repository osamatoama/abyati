<?php

namespace App\Services\Orders\Fulfillment\Admin;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use App\Events\Order\OrderAssignedEvent;

class AssignOrderToEmployee
{
    public bool $isReassign = false;

    public function __construct(
        public Order $order,
        public int $employeeId
    )
    {
        $this->isReassign = $this->order->executions()->exists();
    }

    public function execute()
    {
        DB::transaction(function () {
            $this->order->assignTo($this->employeeId);

            if ($this->order->isPending()) {
                $this->order->setAsProcessing();
            }

            $this->order->logProcessingToHistory($this->employeeId);

            if ($this->isReassign) {
                $this->order->executions()->update([
                    'reassigned' => true,
                ]);
            }

            $this->order->executions()->create([
                'employee_id' => $this->employeeId,
                'started_at' => now(),
                'is_reassign' => $this->isReassign,
            ]);
        });

        $this->dispatchEvents();
    }

    private function dispatchEvents()
    {
        event(new OrderAssignedEvent(
            order: $this->order,
            selfAssign: false,
        ));
    }
}
