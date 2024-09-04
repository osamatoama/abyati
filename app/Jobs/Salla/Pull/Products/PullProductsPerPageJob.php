<?php

namespace App\Jobs\Salla\Pull\Products;

use App\Enums\Queues\BatchName;
use App\Jobs\Concerns\InteractsWithBatches;
use App\Jobs\Concerns\InteractsWithException;
use App\Services\Salla\Merchant\SallaMerchantException;
use App\Services\Salla\Merchant\SallaMerchantService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PullProductsPerPageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithBatches, InteractsWithException, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly string $accessToken,
        public readonly int $storeId,
        public readonly int $page = 1,
        public ?array $response = null,
    ) {
        $this->maxAttempts = 5;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            if ($this->response === null) {
                try {
                    $this->response = SallaMerchantService::withToken(
                        accessToken: $this->accessToken,
                    )->products()->get(
                        page: $this->page,
                    );
                } catch (SallaMerchantException $exception) {
                    $this->handleException(
                        exception: SallaMerchantException::withLines(
                            exception: $exception,
                            lines: [
                                'Exception while pulling products from salla',
                                "Store: {$this->storeId}",
                                "Page: {$this->page}",
                            ],
                        ),
                    );

                    return;
                }
            }

            $jobs = [];
            foreach ($this->response['data'] as $product) {
                $jobs[] = new PullProductJob(
                    accessToken: $this->accessToken,
                    storeId: $this->storeId,
                    data: $product,
                );
            }

            $this->addOrCreateBatch(
                jobs: $jobs,
                batchName: BatchName::SALLA_PULL_PRODUCTS,
                storeId: $this->storeId,
            );

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
