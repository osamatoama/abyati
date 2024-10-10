<?php

namespace App\Services\Orders\Fulfillment\Employee;

use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class ScanOrderItem
{
    public bool $executionCompleted = false;

    public function __construct(
        public OrderItem $item,
    )
    {
        //
    }

    public function execute()
    {
        DB::transaction(function () {
            $this->item->increment('executed_quantity');

            if ($this->item->isPartiallyExecuted()) {
                $this->item->setAsProcessing();

                return;
            }

            if ($this->item->isExecuted()) {
                $this->item->setAsCompleted();

                (new SyncOrderExecutionStatusWithItems(
                    order: $this->item->order
                ))->execute();

                $this->executionCompleted = true;

                return;
            }
        });

        $this->dispatchEvents();
    }

    private function dispatchEvents()
    {
        //
    }
}
