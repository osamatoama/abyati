<?php

namespace App\Jobs\Salla\Pull\Shipments;

use Exception;
use Illuminate\Bus\Queueable;
use App\Enums\Queues\BatchName;
use App\Services\Orders\OrderService;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Jobs\Concerns\InteractsWithBatches;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Jobs\Concerns\HandleExceptions;
use App\Services\Salla\Merchant\SallaMerchantService;
use App\Services\Salla\Merchant\SallaMerchantException;

class PullFirstOrderShipmentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithBatches, HandleExceptions, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly string $accessToken,
        public readonly int    $storeId,
        public readonly array  $data,
    )
    {
        $this->maxAttempts = 1;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $service = SallaMerchantService::withToken(
                accessToken: $this->accessToken,
            );

            try {
                $response = $service->shipments()->get(
                    filters: [
                        'order_id' => $this->data['order_remote_id'],
                    ],
                );
            } catch (SallaMerchantException $exception) {
                $this->handleException(
                    exception: SallaMerchantException::withLines(
                        exception: $exception,
                        lines: [
                            'Exception while pulling order shipments from salla',
                            "Store: {$this->storeId}",
                        ],
                    ),
                );

                return;
            }

            $shipment = $response['data'][0] ?? null;

            if (empty($shipment)) {
                return;
            }

            OrderService::instance()
                ->saveAddress(
                    orderId: $this->data['order_id'],
                    shipment: $shipment,
                );
        } catch (Exception $exception) {
            $this->handleException(
                exception: $exception,
            );
        }
    }
}
