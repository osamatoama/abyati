<?php

namespace App\Livewire\Employee\Stocktakings;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Stocktaking;
use Livewire\Attributes\Locked;

class ProcessStocktaking extends Component
{
    #[Locked]
    public Stocktaking $stocktaking;

    #[On('product-confirmed')]
    // #[On('product-updated')]
    // #[On('order-scanned')]
    public function render()
    {
        $pendingProducts = $this->stocktaking->products->filter(fn ($product) => $product->pivot->confirmed == false && $product->pivot->has_issue == false);
        $confirmedProducts = $this->stocktaking->products->filter(fn ($product) => $product->pivot->confirmed == true);
        $issueProducts = $this->stocktaking->products->filter(fn ($product) => $product->pivot->has_issue == true);

        return view('livewire.employee.stocktakings.process-stocktaking', compact('pendingProducts', 'confirmedProducts', 'issueProducts'));
    }
}
