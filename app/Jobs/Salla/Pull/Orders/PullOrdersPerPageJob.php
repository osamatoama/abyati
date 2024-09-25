<?php

namespace App\Jobs\Salla\Pull\Orders;

use Exception;
use App\Models\Coupon;
use Illuminate\Bus\Queueable;
use App\Enums\Queues\BatchName;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Jobs\Concerns\InteractsWithBatches;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Jobs\Concerns\HandleExceptions;
use App\Services\Salla\Merchant\SallaMerchantService;
use App\Services\Salla\Merchant\SallaMerchantException;

class PullOrdersPerPageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithBatches, HandleExceptions, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly string $accessToken,
        public readonly int    $storeId,
        public readonly int    $page = 1,
        public ?array          $response = null,
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
            if ($this->response === null) {
                try {
                    $this->response = SallaMerchantService::withToken(
                        accessToken: $this->accessToken,
                    )->orders()->get(
                        page: $this->page,
                        filters: $this->filters,
                    );
                } catch (SallaMerchantException $exception) {
                    $this->handleException(
                        exception: SallaMerchantException::withLines(
                            exception: $exception,
                            lines: [
                                'Exception while pulling orders from salla',
                                "Store: {$this->storeId}",
                                "Page: {$this->page}",
                            ],
                        ),
                    );

                    return;
                }
            }

            $jobs = [];
            foreach ($this->response['data'] as $order) {
                /**
                 * TODO: Check statuses here
                 */
                // if (not allowed status) {
                //     continue;
                // }

                // $jobs[] = new PullOrderJob(
                //     accessToken: $this->accessToken,
                //     storeId: $this->storeId,
                //     data: $order,
                // );

                dispatch(new PullOrderJob(
                    accessToken: $this->accessToken,
                    storeId: $this->storeId,
                    data: $order,
                ));

                // $this->addOrCreateBatch(
                //     jobs: $jobs,
                //     batchName: BatchName::SALLA_PULL_ORDERS,
                //     storeId: $this->storeId,
                // );

                // foreach ($jobs as $job) {
                //     $this->prependToChain($job);
                // }
            }

        } catch (Exception $exception) {
            $this->handleException(
                exception: $exception,
            );
        }
    }
}
