<?php

namespace App\Services\Queues;

use App\Enums\Queues\QueueName;
use App\Services\Concerns\HasInstance;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\PendingChain;
use Illuminate\Support\Facades\Bus;

final class ChainService
{
    use HasInstance;

    /**
     * @param  ShouldQueue[]  $jobs
     */
    public function createPendingChain(
        array $jobs,
        QueueName $queueName = QueueName::DEFAULT,
    ): PendingChain {
        return Bus::chain(
            jobs: $jobs,
        )->onQueue(
            // queue: app()->isProduction() ? $queueName->value : QueueName::DEFAULT->value,
            queue: $queueName->value,
        );
    }
}
