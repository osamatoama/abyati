<?php

namespace App\Jobs\Salla\Push\Orders;

use App\Models\Tag;
use App\Models\Order;
use App\Models\Store;
use App\Models\Token;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use App\Jobs\Concerns\HandleExceptions;
use Illuminate\Queue\InteractsWithQueue;
use App\Jobs\Concerns\InteractsWithBatches;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\Salla\Merchant\SallaMerchantService;
use App\Services\Salla\Merchant\SallaMerchantException;

class CreateOrderTagJob implements ShouldQueue
{
    use Dispatchable, InteractsWithBatches, HandleExceptions, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly Token $token,
        public readonly Store $store,
        public readonly Order $order,
        public readonly Tag $tag,
    )
    {
        $this->maxAttempts = 5;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $response = SallaMerchantService::withToken(
                    accessToken: $this->token->accessToken,
                )
                ->orders()
                ->createTag(
                    id: $this->order->remote_id,
                    data: [
                        'tag_name' => $this->tag->name,
                    ],
                );
        } catch (SallaMerchantException $exception) {
            $this->handleException(
                exception: SallaMerchantException::withLines(
                    exception: $exception,
                    lines: [
                        'Exception while pulling order details from salla',
                        "Store: {$this->store->id}",
                        "Order ID: {$this->order->id}",
                    ],
                ),
            );

            return;
        }
    }
}
