<?php

namespace App\Services\Salla\Webhook\Events\Order;

use App\Jobs\Salla\Webhook\Order\OrderUpdatedJob;
use App\Services\Salla\Webhook\Contracts\WebhookEvent;

final class OrderStatusUpdatedEvent implements WebhookEvent
{
    public function __invoke(string $event, int $merchantId, array $data): void
    {
        logger()->notice("Event: {$event}");
        logger()->notice($data);

        OrderUpdatedJob::dispatch(
            event: $event,
            merchantId: $merchantId,
            data: $data,
        );
    }
}
