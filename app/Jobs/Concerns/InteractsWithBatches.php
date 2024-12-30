<?php

namespace App\Jobs\Concerns;

use App\Enums\Queues\BatchName;
use App\Enums\Queues\QueueName;
use App\Services\Queues\BatchService;
use Closure;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;

trait InteractsWithBatches
{
    use Batchable;

    /**
     * @param  ShouldQueue|ShouldQueue[]  $jobs
     */
    protected function createBatch(
        ShouldQueue|array $jobs,
        BatchName $batchName,
        string $storeId,
        QueueName $queueName = QueueName::DEFAULT,
        ?Closure $finallyCallback = null,
        bool $deleteWhenFinished = true,
    ): void {
        BatchService::instance()
            ->createPendingBatch(
                jobs: $jobs,
                batchName: $batchName,
                storeId: $storeId,
                queueName: $queueName,
                finallyCallback: $finallyCallback,
                deleteWhenFinished: $deleteWhenFinished,
            )
            ->dispatch();
    }

    /**
     * @param  ShouldQueue|ShouldQueue[]  $jobs
     */
    protected function addOrCreateBatch(
        ShouldQueue|array $jobs,
        BatchName $batchName,
        string $storeId,
        QueueName $queueName = QueueName::DEFAULT,
        ?Closure $finallyCallback = null,
        bool $deleteWhenFinished = true,
    ): void {
        if ($this->batchId !== null) {
            $this->batch()->add(
                jobs: $jobs,
            );

            return;
        }

        $this->createBatch(
            jobs: $jobs,
            batchName: $batchName,
            storeId: $storeId,
            queueName: $queueName,
            finallyCallback: $finallyCallback,
            deleteWhenFinished: $deleteWhenFinished,
        );
    }
}
