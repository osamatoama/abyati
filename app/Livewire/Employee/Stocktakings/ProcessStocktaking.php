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
    // #[On('order-item-transferred')]
    // #[On('order-scanned')]
    public function render()
    {
        $confirmedProducts = $this->stocktaking->products->filter(fn ($product) => $product->pivot->confirmed == true);
        $issueProducts = $this->stocktaking->products->filter(fn ($product) => $product->pivot->has_issue == true);

        return view('livewire.employee.stocktakings.process-stocktaking', compact('confirmedProducts', 'issueProducts'));
    }
}
