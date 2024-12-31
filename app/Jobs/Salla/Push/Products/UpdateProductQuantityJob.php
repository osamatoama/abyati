<?php

namespace App\Jobs\Salla\Push\Products;

use App\Models\Store;
use App\Models\Token;
use App\Models\Branch;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use App\Jobs\Concerns\HandleExceptions;
use Illuminate\Queue\InteractsWithQueue;
use App\Jobs\Concerns\InteractsWithBatches;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\Salla\Merchant\SallaMerchantService;
use App\Services\Salla\Merchant\SallaMerchantException;

class UpdateProductQuantityJob implements ShouldQueue
{
    use Dispatchable, InteractsWithBatches, HandleExceptions, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly Token $token,
        public readonly Store $store,
        public readonly Product $product,
        public readonly Branch $branch,
    )
    {
        $this->maxAttempts = 5;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (env('ENABLE_REMOTE_UPDATE', false) == false) {
            return;
        }

        $productQuantity = $this->product->quantities()
            ->where('branch_id', $this->branch->id)
            ->first();

        try {
            $response = SallaMerchantService::withToken(
                    accessToken: $this->token->accessToken,
                )
                ->products()
                ->updateQuantity(
                    id: $this->product->remote_id,
                    data: [
                        'quantity' => $productQuantity->quantity,
                        'branch' => $this->branch->remote_id,
                    ],
                );
        } catch (SallaMerchantException $exception) {
            $this->handleException(
                exception: SallaMerchantException::withLines(
                    exception: $exception,
                    lines: [
                        'Exception while updating product quantity in salla',
                        "Store: {$this->store->id}",
                        "Product ID: {$this->product->remote_id}",
                        "Branch ID: {$this->branch->remote_id}",
                    ],
                ),
            );

            return;
        }
    }
}
