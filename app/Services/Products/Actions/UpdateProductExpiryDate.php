<?php

namespace App\Services\Products\Actions;

use App\Models\Branch;
use App\Models\Product;

class UpdateProductExpiryDate
{
    public function __construct(
        public Product $product,
        public Branch $branch,
        public string $expiryDate,
    )
    {
        //
    }

    public function execute()
    {
        $this->product->quantities()->where('branch_id', $this->branch->id)->update([
            'expiry_date' => $this->expiryDate,
        ]);

        $this->dispatchEvents();
    }

    private function dispatchEvents()
    {
        //
    }
}
