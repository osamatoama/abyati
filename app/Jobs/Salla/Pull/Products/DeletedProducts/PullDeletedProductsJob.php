<?php

namespace App\Jobs\Salla\Pull\Products\DeletedProducts;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use App\Jobs\Concerns\HandleExceptions;
use Illuminate\Queue\InteractsWithQueue;
use App\Jobs\Concerns\InteractsWithBatches;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\Salla\Merchant\SallaMerchantService;
use App\Services\Salla\Merchant\SallaMerchantException;

class PullDeletedProductsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithBatches, HandleExceptions, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly string $accessToken,
        public readonly int $storeId,
    ) {
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
                $response = $service->products()->restore();
            } catch (SallaMerchantException $exception) {
                $this->handleException(
                    exception: SallaMerchantException::withLines(
                        exception: $exception,
                        lines: [
                            'Exception while pulling deleted products from salla',
                            "Store: {$this->storeId}",
                        ],
                    ),
                );

                return;
            }

            logger()->debug("Pulling deleted products. Count = " . $response['pagination']['total'] ?? '---');

            $jobs = [];
            for ($page = 1, $totalPages = $response['pagination']['totalPages']; $page <= $totalPages; $page++) {
                $jobs[] = new PullDeletedProductsPerPageJob(
                    accessToken: $this->accessToken,
                    storeId: $this->storeId,
                    page: $page,
                    response: $page === 1 ? $response : null,
                );
            }

            // $this->addOrCreateBatch(
            //     jobs: $jobs,
            //     batchName: BatchName::SALLA_PULL_PRODUCTS,
            //     storeId: $this->storeId,
            // );

            foreach ($jobs as $job) {
                $this->prependToChain($job);
            }
        } catch (Exception $exception) {
            $this->handleException(
                exception: $exception,
            );
        }
    }
}
