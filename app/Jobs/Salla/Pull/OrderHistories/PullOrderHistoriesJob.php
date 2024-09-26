<?php

namespace App\Jobs\Salla\Pull\OrderHistories;

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

class PullOrderHistoriesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithBatches, HandleExceptions, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly string $accessToken,
        public readonly int $storeId,
        public readonly int $orderId,
        public readonly int $orderRemoteId,
        public readonly bool $statusChangesOnly = false,
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
                $response = $service->orderHistories()->get(
                    orderId: $this->orderRemoteId,
                );
            } catch (SallaMerchantException $exception) {
                $this->handleException(
                    exception: SallaMerchantException::withLines(
                        exception: $exception,
                        lines: [
                            'Exception while pulling order histories from salla',
                            "Store: {$this->storeId}",
                            "OrderId: {$this->orderId}",
                            "OrderRemoteId: {$this->orderRemoteId}",
                        ],
                    ),
                );

                return;
            }

            $jobs = [];
            for ($page = 1, $totalPages = $response['pagination']['totalPages']; $page <= $totalPages; $page++) {
                $jobs[] = new PullOrderHistoriesPerPageJob(
                    accessToken: $this->accessToken,
                    storeId: $this->storeId,
                    orderId: $this->orderId,
                    orderRemoteId: $this->orderRemoteId,
                    page: $page,
                    response: $page === 1 ? $response : null,
                    statusChangesOnly: $this->statusChangesOnly,
                );
            }

            // $this->addOrCreateBatch(
            //     jobs: $jobs,
            //     batchName: BatchName::SALLA_PULL_ORDER_HISTORIES,
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
