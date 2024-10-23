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
        if ($this->item->executed_quantity == $this->item->quantity) {
            return;
        }

        if ($this->item->executed_quantity > $this->item->quantity) {
            $this->handleScanIncrementError();

            return;
        }

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

    public function handleScanIncrementError()
    {
        DB::transaction(function () {
            $this->item->update([
                'executed_quantity' => $this->item->quantity,
            ]);

            $this->item->setAsCompleted();

            (new SyncOrderExecutionStatusWithItems(
                order: $this->item->order
            ))->execute();

            $this->executionCompleted = true;
        });
    }

    private function dispatchEvents()
    {
        //
    }
}
