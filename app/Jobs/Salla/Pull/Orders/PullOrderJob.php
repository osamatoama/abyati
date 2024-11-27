<?php

namespace App\Jobs\Salla\Pull\Orders;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use App\Jobs\Concerns\HandleExceptions;
use Illuminate\Queue\InteractsWithQueue;
use App\Jobs\Concerns\InteractsWithBatches;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\Orders\Api\SyncOrderService;
use App\Services\Salla\Merchant\SallaMerchantService;
use App\Services\Salla\Merchant\SallaMerchantException;

class PullOrderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithBatches, HandleExceptions, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly string $accessToken,
        public readonly int $storeId,
        public readonly array $data,
    ) {
        $this->maxAttempts = 5;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $response = SallaMerchantService::withToken(
                accessToken: $this->accessToken,
            )->orders()->details(
                id: $this->data['id'],
                filters: [
                    'format' => 'light',
                ],
            );
        } catch (SallaMerchantException $exception) {
            $this->handleException(
                exception: SallaMerchantException::withLines(
                    exception: $exception,
                    lines: [
                        'Exception while pulling order details from salla',
                        "Store: {$this->storeId}",
                        "Order ID: {$this->data['id']}",
                    ],
                ),
            );

            return;
        }

        try {
            SyncOrderService::instance()
                ->save(
                    sallaOrder: $response['data'],
                    storeId: $this->storeId,
                    accessToken: $this->accessToken,
                );
        } catch (Exception $exception) {
            $this->handleException(
                exception: $exception,
            );
        }
    }
}
