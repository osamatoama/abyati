<?php

namespace App\Jobs\Salla\Pull\Products;

use Exception;
use Illuminate\Bus\Queueable;
use App\Enums\Queues\BatchName;
use App\Enums\Queues\QueueName;
use Illuminate\Queue\SerializesModels;
use App\Jobs\Concerns\HandleExceptions;
use Illuminate\Queue\InteractsWithQueue;
use App\Jobs\Concerns\InteractsWithBatches;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\Salla\Merchant\SallaMerchantService;
use App\Services\Salla\Merchant\SallaMerchantException;

class PullProductsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithBatches, HandleExceptions, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly string $accessToken,
        public readonly int $storeId,
        public readonly int $page = 1,
    ) {
        $this->maxAttempts = 5;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            try {
                $response = SallaMerchantService::withToken(
                        accessToken: $this->accessToken,
                    )
                    ->products()
                    ->get(
                        page: $this->page,
                    );
            } catch (SallaMerchantException $exception) {
                $this->handleException(
                    exception: SallaMerchantException::withLines(
                        exception: $exception,
                        lines: [
                            'Exception while pulling products from salla',
                            "Store: {$this->storeId}",
                        ],
                    ),
                );

                return;
            }

            $jobs = [];

            foreach ($response['data'] as $product) {
                $jobs[] = new SaveProductJob(
                    accessToken: $this->accessToken,
                    storeId: $this->storeId,
                    data: $product,
                );
            }

            $this->addOrCreateBatch(
                jobs: $jobs,
                batchName: BatchName::SALLA_PULL_PRODUCTS,
                queueName: QueueName::PULL,
                storeId: $this->storeId,
            );

            $chainedJobs = [];

            if (! empty($response['pagination']['links']['next'])) {
                $chainedJobs[] = new self(
                    accessToken: $this->accessToken,
                    storeId: $this->storeId,
                    page: $this->page + 1,
                );
            }

            foreach ($chainedJobs as $job) {
                $this->appendToChain($job);
            }
        } catch (Exception $exception) {
            $this->handleException(
                exception: $exception,
            );
        }
    }
}
