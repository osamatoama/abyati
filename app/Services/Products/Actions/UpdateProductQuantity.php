<?php

namespace App\Services\Products\Actions;

use App\Models\Branch;
use App\Models\Product;
use App\Services\Products\Salla\Push\SallaUpdateProductQuantity;

class UpdateProductQuantity
{
    public function __construct(
        public Product $product,
        public Branch $branch,
        public string $quantity,
        public bool $remoteUpdate = false,
    )
    {
        //
    }

    public function execute()
    {
        $this->product->quantities()->where('branch_id', $this->branch->id)->update([
            'quantity' => $this->quantity,
        ]);

        if ($this->remoteUpdate) {
            $this->remoteUpdate();
        }

        $this->dispatchEvents();
    }

    private function remoteUpdate()
    {
        (new SallaUpdateProductQuantity(
            token: $this->product->store->user->sallaToken,
            store: $this->product->store,
            product: $this->product,
            branch: $this->branch,
        ))->handle();
    }

    private function dispatchEvents()
    {
        //
    }
}
