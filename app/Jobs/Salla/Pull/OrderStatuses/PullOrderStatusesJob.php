<?php

namespace App\Jobs\Salla\Pull\OrderStatuses;

use App\Enums\Queues\BatchName;
use App\Jobs\Concerns\InteractsWithBatches;
use App\Jobs\Concerns\HandleExceptions;
use App\Services\Salla\Merchant\SallaMerchantException;
use App\Services\Salla\Merchant\SallaMerchantService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PullOrderStatusesJob implements ShouldQueue
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
                $response = $service->orderStatuses()->get();
            } catch (SallaMerchantException $exception) {
                $this->handleException(
                    exception: SallaMerchantException::withLines(
                        exception: $exception,
                        lines: [
                            'Exception while pulling order statuses from salla',
                            "Store: {$this->storeId}",
                        ],
                    ),
                );

                return;
            }

            $jobs = [];
            foreach ($response['data'] as $orderStatus) {
                $jobs[] = new PullOrderStatusJob(
                    accessToken: $this->accessToken,
                    storeId: $this->storeId,
                    data: $orderStatus,
                );
            }

            // $this->addOrCreateBatch(
            //     jobs: $jobs,
            //     batchName: BatchName::SALLA_PULL_ORDER_STATUSES,
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
