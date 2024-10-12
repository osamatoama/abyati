<?php

namespace App\Services\Orders\Fulfillment\Employee;

use App\Models\Order;
use App\Models\Employee;
use App\Enums\Queues\QueueName;
use Illuminate\Support\Facades\DB;
use App\Events\Order\OrderAssignedEvent;
use App\Jobs\Orders\CheckOrderProcessingDelay;

class AssignOrderToMe
{
    public int $employeeId;

    public bool $isReassign = false;

    public function __construct(
        public Order $order,
    )
    {
        $this->employeeId = auth('employee')->id();
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

            Employee::find(auth('employee')->id())?->update([
                'current_assigned_order_id' => $this->order->id,
            ]);
        });

        $this->dispatchEvents();
    }

    private function dispatchEvents()
    {
        CheckOrderProcessingDelay::dispatch($this->order)
            ->onQueue(QueueName::BROADCAST->value)
            ->delay(now()->addMinutes(2));

        event(new OrderAssignedEvent(
            order: $this->order,
            selfAssign: true,
        ));
    }
}
