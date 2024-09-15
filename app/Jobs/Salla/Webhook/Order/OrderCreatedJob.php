<?php

namespace App\Jobs\Salla\Webhook\Order;

use App\Jobs\Concerns\InteractsWithException;
use App\Jobs\Salla\Contracts\WebhookEvent;
use App\Models\Store;
use App\Services\Orders\OrderService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class OrderCreatedJob implements ShouldQueue, WebhookEvent
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

            OrderService::instance()
                ->saveSallaOrder(
                    sallaOrder: $this->data,
                    storeId: $store->id,
                    accessToken: $store->user->sallaToken->access_token,
                );
        } catch (Exception $exception) {
            $this->handleException(
                exception: $exception,
            );
        }
    }
}
