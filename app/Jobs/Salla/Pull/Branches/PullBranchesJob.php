<?php

namespace App\Jobs\Salla\Pull\Branches;

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

class PullBranchesJob implements ShouldQueue
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
            try {
                $response = SallaMerchantService::withToken(
                        accessToken: $this->accessToken,
                    )
                    ->branches()
                    ->get();
            } catch (SallaMerchantException $exception) {
                $this->handleException(
                    exception: SallaMerchantException::withLines(
                        exception: $exception,
                        lines: [
                            'Exception while pulling branches from salla',
                            "Store: {$this->storeId}",
                        ],
                    ),
                );

                return;
            }

            $jobs = [];
            for ($page = 1, $totalPages = $response['pagination']['totalPages']; $page <= $totalPages; $page++) {
                $jobs[] = new PullBranchesPerPageJob(
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
