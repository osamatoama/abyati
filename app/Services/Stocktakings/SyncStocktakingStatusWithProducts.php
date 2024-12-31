<?php

namespace App\Services\Stocktakings;

use App\Models\Stocktaking;
use Illuminate\Support\Facades\DB;

class SyncStocktakingStatusWithProducts
{
    public function __construct(
        public Stocktaking $stocktaking,
    )
    {
        $this->stocktaking->refresh()->load('products');
    }

    public function execute()
    {
        if ($this->stocktaking->isExecuted()) {
            $this->stocktaking->setAsCompleted();

            $this->dispatchCompletionEvents();
        }
    }

    private function dispatchCompletionEvents()
    {
        //
    }
}
