<?php

namespace App\Services\Queues;

use App\Enums\Queues\BatchName;
use App\Enums\Queues\QueueName;
use App\Services\Concerns\HasInstance;
use Closure;
use Illuminate\Bus\Batch;
use Illuminate\Bus\PendingBatch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Bus;

final class BatchService
{
    use HasInstance;

    /**
     * @param  ShouldQueue|ShouldQueue[]  $jobs
     */
    public function createPendingBatch(
        ShouldQueue|array $jobs,
        BatchName $batchName,
        int $storeId,
        QueueName $queueName = QueueName::DEFAULT,
        ?Closure $finallyCallback = null,
        bool $deleteWhenFinished = true,
    ): PendingBatch {
        $pendingBatch = Bus::batch(
            jobs: $jobs,
        )->name(
            name: $this->generateBatchName(
                batchName: $batchName,
                storeId: $storeId,
            ),
        )->onQueue(
            queue: app()->isProduction() ? $queueName->value : QueueName::DEFAULT->value,
        );

        if ($finallyCallback !== null || $deleteWhenFinished) {
            $pendingBatch->finally(
                callback: function (Batch $batch) use ($finallyCallback, $deleteWhenFinished): void {
                    if ($finallyCallback !== null) {
                        $finallyCallback(
                            batch: $batch,
                        );
                    }

                    if ($deleteWhenFinished) {
                        $batch->delete();
                    }
                },
            );
        }

        return $pendingBatch;
    }

    protected function generateBatchName(BatchName $batchName, int $storeId): string
    {
        return "{$batchName->value}:{$storeId}";
    }
}
