<?php

namespace App\Jobs\Salla\Pull\Products;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use App\Jobs\Concerns\HandleExceptions;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\Products\ProductService;
use App\Jobs\Concerns\InteractsWithBatches;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\Salla\Merchant\SallaMerchantService;
use App\Services\Salla\Merchant\SallaMerchantException;

class PullProductJob implements ShouldQueue
{
    use Dispatchable, InteractsWithBatches, HandleExceptions, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly string $accessToken,
        public readonly int $storeId,
        public readonly int $remoteId,
        public readonly bool $markAsSynced = false,
    ) {
        $this->maxAttempts = 1;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            try {
                $response = SallaMerchantService::withToken(
                        accessToken: $this->accessToken,
                    )
                    ->products()
                    ->details(
                        id: $this->remoteId,
                    );
            } catch (SallaMerchantException $exception) {
                $this->handleException(
                    exception: SallaMerchantException::withLines(
                        exception: $exception,
                        lines: [
                            'Exception while pulling product details from salla',
                            "Store: {$this->storeId}",
                            "Product: {$this->remoteId}",
                        ],
                    ),
                );

                return;
            }

            $product = ProductService::instance()
                ->saveSallaProduct(
                    sallaProduct: $response['data'],
                    storeId: $this->storeId,
                );

            if ($this->markAsSynced) {
                $product->markAsSynced();
            }

        } catch (Exception $exception) {
            $this->handleException(
                exception: $exception,
            );
        }
    }
}
