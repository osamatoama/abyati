<?php

namespace App\Jobs\Salla\Pull\Shipments;

use Exception;
use Illuminate\Bus\Queueable;
use App\Services\Orders\OrderService;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Jobs\Concerns\InteractsWithBatches;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Jobs\Concerns\InteractsWithException;

class PullShipmentJob implements ShouldQueue
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
            // OrderService::instance()
            //     ->saveSallaOrder(
            //         sallaOrder: $this->shipment,
            //         storeId: $this->storeId,
            //         accessToken: $this->accessToken,
            //     );
        } catch (Exception $exception) {
            $this->handleException(
                exception: $exception,
            );
        }
    }
}
