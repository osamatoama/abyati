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

class PullCustomProductsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithBatches, HandleExceptions, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly string $accessToken,
        public readonly int $storeId,
        public readonly array $remoteIds = [],
        public readonly bool $markAsSynced = false,
        public readonly ?string $batchSuffix = null,
    ) {
        $this->maxAttempts = 5;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (empty($this->remoteIds)) {
            return;
        }

        try {
            $jobs = [];

            foreach ($this->remoteIds as $remoteId) {
                $jobs[] = new PullProductJob(
                    accessToken: $this->accessToken,
                    storeId: $this->storeId,
                    remoteId: $remoteId,
                    markAsSynced: $this->markAsSynced,
                );
            }

            $this->addOrCreateBatch(
                jobs: $jobs,
                batchName: BatchName::SALLA_PULL_PRODUCTS,
                queueName: QueueName::PULL,
                storeId: filled($this->batchSuffix) ? $this->batchSuffix : $this->storeId,
            );
        } catch (Exception $exception) {
            $this->handleException(
                exception: $exception,
            );
        }
    }
}
