<?php

namespace App\Jobs\Salla\Webhook\Product;

use Exception;
use App\Models\Store;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\Products\ProductService;
use App\Jobs\Salla\Contracts\WebhookEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Jobs\Concerns\InteractsWithException;

class ProductCreatedJob implements ShouldQueue, WebhookEvent
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

            ProductService::instance()
                ->saveSallaProduct(
                    sallaProduct: $this->data,
                    storeId: $store->id,
                );
        } catch (Exception $exception) {
            $this->handleException(
                exception: $exception,
            );
        }
    }
}
