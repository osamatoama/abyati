<?php

namespace App\Services\Salla\Webhook\Events\Product;

use App\Jobs\Salla\Webhook\Product\ProductDeletedJob;
use App\Services\Salla\Webhook\Contracts\WebhookEvent;

final class ProductDeletedEvent implements WebhookEvent
{
    public function __invoke(string $event, int $merchantId, array $data): void
    {
        // logger()->notice("Event: {$event}");
        // logger()->notice($data);

        ProductDeletedJob::dispatch(
            event: $event,
            merchantId: $merchantId,
            data: $data,
        );
    }
}
