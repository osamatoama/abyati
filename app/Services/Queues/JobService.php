<?php

namespace App\Services\Queues;

use App\Enums\Queues\QueueName;
use App\Services\Concerns\HasInstance;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\PendingDispatch;

final class JobService
{
    use HasInstance;

    public function dispatch(ShouldQueue $job, QueueName $queueName = QueueName::DEFAULT): PendingDispatch
    {
        return dispatch(
            job: $job,
        )->onQueue(
            // queue: app()->isProduction() ? $queueName->value : QueueName::DEFAULT->value,
            queue: $queueName->value,
        );
    }
}
