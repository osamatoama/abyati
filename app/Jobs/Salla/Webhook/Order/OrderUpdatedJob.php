<?php

namespace App\Jobs\Salla\Webhook\Order;

use Exception;
use App\Models\Order;
use App\Models\Store;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use App\Jobs\Concerns\HandleExceptions;
use Illuminate\Queue\InteractsWithQueue;
use App\Jobs\Salla\Contracts\WebhookEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\Orders\Webhooks\CreateOrderService;
use App\Services\Orders\Webhooks\UpdateOrderService;

class OrderUpdatedJob implements ShouldQueue, WebhookEvent
{
    use Dispatchable, HandleExceptions, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly string $event,
        public readonly int $merchantId,
        public readonly array $data,
    ) {
        $this->tries = 1;
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
                $pullOrderStatuses = $store->branchOrderStatuses;

                if (
                    ! in_array($this->data['status']['id'] ?? null, $pullOrderStatuses->pluck('remote_original_id')->toArray())
                    && ! in_array($this->data['status']['customized']['id'] ?? null, $pullOrderStatuses->pluck('remote_id')->toArray())
                ) {
                    return;
                }
    
                CreateOrderService::instance()
                    ->save(
                        sallaOrder: $this->data,
                        storeId: $store->id,
                        accessToken: $store->user->sallaToken->access_token,
                    );

                return;
            }

            UpdateOrderService::instance()
                ->save(
                    order: $order,
                    sallaOrder: $this->data,
                    storeId: $store->id,
                    accessToken: $store->user->sallaToken->access_token,
                );
        } catch (Exception $exception) {
            // $this->handleException(
            //     exception: $exception,
            // );

            throw $exception;
        }
    }
}
