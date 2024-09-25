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

class PullOrderHistoriesPerPageJob implements ShouldQueue
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
        public readonly int $page = 1,
        public ?array $response = null,
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
            if ($this->response === null) {
                try {
                    $this->response = SallaMerchantService::withToken(
                        accessToken: $this->accessToken,
                    )->orderHistories()->get(
                        orderId: $this->orderRemoteId,
                        page: $this->page,
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
                                "Page: {$this->page}",
                            ],
                        ),
                    );

                    return;
                }
            }

            $jobs = [];
            foreach ($this->response['data'] as $i => $orderHistory) {
                logger()->debug($orderHistory);

                if (
                    $this->statusChangesOnly
                    && !empty($this->response['data'][$i-1]['status'])
                    && $orderHistory['status'] == $this->response['data'][$i-1]['status']
                ) {
                    continue;
                }

                $jobs[] = new PullOrderHistoryJob(
                    storeId: $this->storeId,
                    orderId: $this->orderId,
                    data: $orderHistory,
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
