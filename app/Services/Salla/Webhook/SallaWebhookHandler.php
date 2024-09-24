<?php

namespace App\Services\Salla\Webhook;

use App\Services\Salla\Webhook\Events\UnknownEvent;
use App\Services\Salla\Webhook\Events\Order\OrderCreatedEvent;
use App\Services\Salla\Webhook\Events\Order\OrderUpdatedEvent;
use App\Services\Salla\Webhook\Events\Product\ProductCreatedEvent;
use App\Services\Salla\Webhook\Events\Product\ProductUpdatedEvent;
use App\Services\Salla\Webhook\Events\App\Store\AppStoreAuthorizeEvent;
use App\Services\Salla\Webhook\Events\Order\OrderShippingAddressUpdatedEvent;

final class SallaWebhookHandler
{
    public function isVerified(string $token): bool
    {
        return $token === config(
            key: 'services.salla.webhook_token',
        );
    }

    public function isNotVerified(string $token): bool
    {
        return ! $this->isVerified(
            token: $token,
        );
    }

    public function handle(string $event, int $merchantId, array $data): void
    {
        (match ($event) {
            'app.store.authorize' => new AppStoreAuthorizeEvent(),
            'product.created' => new ProductCreatedEvent(),
            'product.updated' => new ProductUpdatedEvent(),
            'order.created' => new OrderCreatedEvent(),
            'order.updated' => new OrderUpdatedEvent(),
            'order.shipping.address.updated' => new OrderShippingAddressUpdatedEvent(),
            default => new UnknownEvent(),
        })(
            event: $event,
            merchantId: $merchantId,
            data: $data,
        );
    }
}
