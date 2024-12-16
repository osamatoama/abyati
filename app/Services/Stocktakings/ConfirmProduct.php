<?php

namespace App\Services\Stocktakings;

use App\Models\Product;
use App\Models\Stocktaking;

class ConfirmProduct
{
    public bool $executionCompleted = false;

    public function __construct(
        public Stocktaking $stocktaking,
        public Product $product,
    )
    {
        //
    }

    public function execute()
    {
        $this->stocktaking->products()->syncWithoutDetaching([$this->product->id => [
            'confirmed' => true,
            'has_issue' => false,
        ]]);

        $this->dispatchEvents();
    }

    private function dispatchEvents()
    {
        //
    }
}
