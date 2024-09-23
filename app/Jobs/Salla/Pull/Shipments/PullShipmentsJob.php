<?php

namespace App\Jobs\Salla\Pull\Shipments;

use Exception;
use Illuminate\Bus\Queueable;
use App\Enums\Queues\BatchName;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Jobs\Concerns\InteractsWithBatches;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Jobs\Concerns\InteractsWithException;
use App\Services\Salla\Merchant\SallaMerchantService;
use App\Services\Salla\Merchant\SallaMerchantException;

class PullShipmentsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithBatches, InteractsWithException, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly string $accessToken,
        public readonly int    $storeId,
        public readonly array  $filters = [],
    )
    {
        $this->maxAttempts = 5;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $service = SallaMerchantService::withToken(
                accessToken: $this->accessToken,
            );

            try {
                $response = $service->shipments()->get(
                    filters: $this->filters,
                );
            } catch (SallaMerchantException $exception) {
                $this->handleException(
                    exception: SallaMerchantException::withLines(
                        exception: $exception,
                        lines: [
                            'Exception while pulling shipments from salla',
                            "Store: {$this->storeId}",
                        ],
                    ),
                );

                return;
            }

            $jobs = [];
            for ($page = 1, $totalPages = $response['pagination']['totalPages']; $page <= $totalPages; $page++) {
                // $jobs[] = new PullOrdersPerPageJob(
                //     accessToken: $this->accessToken,
                //     storeId: $this->storeId,
                //     page: $page,
                //     response: $page === 1 ? $response : null,
                //     filters: $this->filters,
                // );

                dispatch(new PullShipmentsPerPageJob(
                    accessToken: $this->accessToken,
                    storeId: $this->storeId,
                    page: $page,
                    response: $page === 1 ? $response : null,
                    filters: $this->filters,
                ));
            }

            // $this->addOrCreateBatch(
            //     jobs: $jobs,
            //     batchName: BatchName::SALLA_PULL_ORDERS,
            //     storeId: $this->storeId,
            // );
        } catch (Exception $exception) {
            $this->handleException(
                exception: $exception,
            );
        }
    }
}
