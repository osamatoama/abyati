<?php

namespace App\Jobs\Orders;

use App\Models\Order;
use Illuminate\Queue\SerializesModels;
use App\Jobs\Concerns\HandleExceptions;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Jobs\Concerns\InteractsWithBatches;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Events\Order\OrderProcessingDelayedEvent;

class CheckOrderProcessingDelay implements ShouldQueue
{
    use Queueable, InteractsWithBatches, HandleExceptions;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Order $order,
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $order = $this->order->fresh()->load('items');

        if ($order->startedProcessing()) {
            return;
        }

        event(new OrderProcessingDelayedEvent(
            order: $order,
        ));
    }
}
