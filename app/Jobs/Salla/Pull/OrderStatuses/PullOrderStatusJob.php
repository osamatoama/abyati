<?php

namespace App\Jobs\Salla\Pull\OrderStatuses;

use App\Jobs\Concerns\InteractsWithBatches;
use App\Jobs\Concerns\InteractsWithException;
use App\Services\Orders\OrderStatusService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PullOrderStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithBatches, InteractsWithException, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly string $accessToken,
        public readonly int $storeId,
        public readonly array $data,
    ) {
        $this->maxAttempts = 5;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            OrderStatusService::instance()
                ->saveSallaOrderStatus(
                    sallaOrderStatus: $this->data,
                    storeId: $this->storeId,
                );
        } catch (Exception $exception) {
            $this->handleException(
                exception: $exception,
            );
        }
    }
}
