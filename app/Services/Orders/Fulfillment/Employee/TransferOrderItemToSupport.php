<?php

namespace App\Services\Orders\Fulfillment\Employee;

use App\Models\Employee;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class TransferOrderItemToSupport
{
    public function __construct(
        public OrderItem $item,
        public ?string $note = null,
    )
    {
        //
    }

    public function execute()
    {
        DB::transaction(function () {
            $this->item->setAsQuantityIssues();

            $this->item->order->setAsQuantityIssues();

            $this->item->order->logQuantityIssuesToHistory(auth('employee')->id());

            if (filled($this->note)) {
                $this->item->notes()->create([
                    'author_id' => auth('employee')->id(),
                    'author_type' => Employee::class,
                    'content' => $this->note,
                ]);
            }
        });

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
