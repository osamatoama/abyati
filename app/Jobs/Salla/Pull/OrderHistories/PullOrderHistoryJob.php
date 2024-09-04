<?php

namespace App\Jobs\Salla\Pull\OrderHistories;

use App\Jobs\Concerns\InteractsWithBatches;
use App\Jobs\Concerns\InteractsWithException;
use App\Services\Orders\OrderHistoryService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PullOrderHistoryJob implements ShouldQueue
{
    use Dispatchable, InteractsWithBatches, InteractsWithException, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly int $storeId,
        public readonly int $orderId,
        public array $data,
    ) {
        $this->maxAttempts = 5;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            OrderHistoryService::instance()
                ->saveSallaOrderHistory(
                    sallaOrderHistory: $this->data,
                    storeId: $this->storeId,
                    orderId: $this->orderId,
                );
        } catch (Exception $exception) {
            $this->handleException(
                exception: $exception,
            );
        }
    }
}
