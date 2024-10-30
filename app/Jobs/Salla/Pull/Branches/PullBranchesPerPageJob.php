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

class PullBranchesPerPageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithBatches, HandleExceptions, InteractsWithQueue, Queueable, SerializesModels;

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
                        )
                        ->branches()
                        ->get(
                            page: $this->page,
                        );
                } catch (SallaMerchantException $exception) {
                    $this->handleException(
                        exception: SallaMerchantException::withLines(
                            exception: $exception,
                            lines: [
                                'Exception while pulling branches from salla',
                                "Store: {$this->storeId}",
                                "Page: {$this->page}",
                            ],
                        ),
                    );

                    return;
                }
            }

            $jobs = [];
            foreach ($this->response['data'] as $branch) {
                $jobs[] = new PullBranchJob(
                    accessToken: $this->accessToken,
                    storeId: $this->storeId,
                    data: $branch,
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
