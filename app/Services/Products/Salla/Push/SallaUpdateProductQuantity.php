<?php

namespace App\Services\Products\Salla\Push;

use Exception;
use App\Models\Store;
use App\Models\Token;
use App\Models\Branch;
use App\Models\Product;
use App\Services\Salla\Merchant\SallaMerchantService;
use App\Exceptions\Salla\FailedToUpdateProductQuantityException;

class SallaUpdateProductQuantity
{
    public function __construct(
        public readonly Token $token,
        public readonly Store $store,
        public readonly Product $product,
        public readonly Branch $branch,
    )
    {
        //
    }

    public function handle(): void
    {
        if (env('ENABLE_REMOTE_UPDATE', false) == false) {
            throw new FailedToUpdateProductQuantityException(__('employee.stocktakings.errors.cannot_update_salla_quantity_in_this_env'));

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
        } catch (Exception $exception) {
            logger()->error('Failed to update product quantity remotely', [
                'product' => $this->product->id,
                'branch' => $this->branch->id,
                'exception' => $exception->getMessage(),
            ]);

            throw new FailedToUpdateProductQuantityException(__('employee.stocktakings.errors.failed_to_update_salla_quantity'));
        }
    }
}
