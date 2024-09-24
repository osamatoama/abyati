<?php

namespace App\Jobs\Salla\Webhook\Order;

use Exception;
use App\Models\Order;
use App\Models\Store;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Jobs\Salla\Contracts\WebhookEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Jobs\Concerns\InteractsWithException;
use App\Services\Orders\Webhooks\UpdateOrderShippingAddressService;

class OrderShippingAddressUpdatedJob implements ShouldQueue, WebhookEvent
{
    use Dispatchable, InteractsWithException, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly string $event,
        public readonly int $merchantId,
        public readonly array $data,
    ) {
        $this->maxAttempts = 1;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $store = Store::query()->salla(providerId: $this->merchantId)->first();

            if ($store === null) {
                return;
            }

            $order = Order::query()
                ->forStore($store)
                ->where('remote_id', $this->data['id'])
                ->first();

            if (! $order) {
                return;
            }

            UpdateOrderShippingAddressService::instance()
                ->handle(
                    order: $order,
                    sallaOrder: $this->data,
                    storeId: $store->id,
                );
        } catch (Exception $exception) {
            $this->handleException(
                exception: $exception,
            );
        }
    }
}
