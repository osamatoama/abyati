<?php

namespace App\Services\Salla\Webhook\Events\Order;

use App\Services\Salla\Webhook\Contracts\WebhookEvent;
use App\Jobs\Salla\Webhook\Order\OrderStatusUpdatedJob;

final class OrderStatusUpdatedEvent implements WebhookEvent
{
    public function __invoke(string $event, int $merchantId, array $data): void
    {
        // logger()->notice("Event: {$event}");
        // logger()->notice($data);

        return;

        OrderStatusUpdatedJob::dispatch(
            event: $event,
            merchantId: $merchantId,
            data: $data,
        );
    }
}
