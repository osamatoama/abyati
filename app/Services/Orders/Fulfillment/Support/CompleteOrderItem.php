<?php

namespace App\Services\Orders\Fulfillment\Support;

use App\Models\Support;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class CompleteOrderItem
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
            $this->item->setAsCompleted();

            $order = $this->item->order;

            if ($order->items->every(fn(OrderItem $item) => $item->isCompleted())) {
                $order->setAsCompleted();

                $order->logCompletedToHistory(
                    executorType: Support::class,
                    executorId: auth('support')->id(),
                );
            }
        });

        $this->dispatchEvents();
    }

    private function dispatchEvents()
    {
        //
    }
}
