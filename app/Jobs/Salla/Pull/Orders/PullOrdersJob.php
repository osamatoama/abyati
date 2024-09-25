<?php

namespace App\Jobs\Salla\Pull\Orders;

use Exception;
use App\Models\Store;
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

class PullOrdersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithBatches, HandleExceptions, InteractsWithQueue, Queueable, SerializesModels;

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
            $store = Store::findOrFail($this->storeId);
            $pullOrderStatuses = $store->branchOrderStatuses;

            if ($pullOrderStatuses->isEmpty()) {
                return;
            }

            $filters = array_merge([
                'status' => $pullOrderStatuses->pluck('remote_id')->toArray(),
            ], $this->filters);

            try {
                $response = SallaMerchantService::withToken(
                    accessToken: $this->accessToken,
                )->orders()->get(
                    filters: $filters,
                );
            } catch (SallaMerchantException $exception) {
                $this->handleException(
                    exception: SallaMerchantException::withLines(
                        exception: $exception,
                        lines: [
                            'Exception while pulling orders from salla',
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
                //     filters: $filters,
                // );

                dispatch(new PullOrdersPerPageJob(
                    accessToken: $this->accessToken,
                    storeId: $this->storeId,
                    page: $page,
                    response: $page === 1 ? $response : null,
                    filters: $filters,
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
