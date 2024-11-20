<?php

namespace App\Enums\Queues;

use App\Enums\Concerns\InteractsWithArrays;

enum QueueName: string
{
    use InteractsWithArrays;

    case DEFAULT = 'default';

    case BROADCAST = 'broadcast';

    case PULL = 'pull';

    case EXCEL = 'excel';
}
