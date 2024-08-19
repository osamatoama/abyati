<?php

namespace App\Enums;

use App\Enums\Concerns\InteractsWithArrays;

enum OrderItemCompletionStatus: string
{
    use InteractsWithArrays;

    /**
     * Cases
     */
    case PENDING = 'pending';

    case PROCESSING = 'processing';

    case QUANTITY_ISSUES = 'quantity_issues';

    case COMPLETED = 'completed';
}
