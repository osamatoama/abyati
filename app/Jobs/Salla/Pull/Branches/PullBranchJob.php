<?php

namespace App\Jobs\Salla\Pull\Branches;

use Exception;
use App\Models\Store;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use App\Jobs\Concerns\HandleExceptions;
use App\Services\Branches\BranchService;
use Illuminate\Queue\InteractsWithQueue;
use App\Jobs\Concerns\InteractsWithBatches;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class PullBranchJob implements ShouldQueue
{
    use Dispatchable, InteractsWithBatches, HandleExceptions, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly string $accessToken,
        public readonly int $storeId,
        public readonly array $data,
    ) {
        $this->maxAttempts = 1;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            BranchService::instance()
                ->saveSallaBranch(
                    store: Store::query()->findOrFail($this->storeId),
                    data: $this->data,
                );
        } catch (Exception $exception) {
            $this->handleException(
                exception: $exception,
            );
        }
    }
}
