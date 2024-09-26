<?php

namespace App\Jobs\Salla\Pull\OrderItems;

use Exception;
use Illuminate\Bus\Queueable;
use App\Dto\Orders\OrderItemDto;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\Orders\OrderItemService;
use App\Jobs\Concerns\InteractsWithBatches;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Jobs\Concerns\HandleExceptions;
use App\Services\Salla\Merchant\SallaMerchantService;
use App\Services\Salla\Merchant\SallaMerchantException;

class PullOrderItemsJob implements ShouldQueue
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
            )->orderItems()->get(
                orderId: $this->data['order_remote_id'],
            );
        } catch (SallaMerchantException $exception) {
            $this->handleException(
                exception: SallaMerchantException::withLines(
                    exception: $exception,
                    lines: [
                        'Exception while pulling order items from salla',
                        "Store: {$this->storeId}",
                        "Order ID: {$this->data['order_remote_id']}",
                    ],
                ),
            );

            return;
        }

        try {
            foreach ($response['data'] ?? [] as $item) {
                OrderItemService::instance()
                    ->updateOrCreate(
                        orderItemDto: OrderItemDto::fromSalla(
                            sallaOrderItem: $item,
                            orderId: $this->data['order_id'],
                        ),
                    );
            }
        } catch (Exception $exception) {
            $this->handleException(
                exception: $exception,
            );
        }
    }
}
