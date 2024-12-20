<?php

namespace App\Livewire\Support\Orders;

use App\Models\Order;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Locked;

class ProcessOrder extends Component
{
    #[Locked]
    public Order $order;

    #[On('order-item-completed')]
    public function render()
    {
        // $executedItems = $this->order->items->filter(fn ($item) => $item->isCompleted() && $item->issue_quantity > 0);
        // $quantityIssuesItems = $this->order->items->filter(fn ($item) => $item->isQuantityIssues());

        $executedItems = $this->order->decomposedItems->filter(fn ($item) => $item->isCompleted() && $item->issue_quantity > 0);
        $quantityIssuesItems = $this->order->decomposedItems->filter(fn ($item) => $item->isQuantityIssues());

        return view('livewire.support.orders.process-order', compact('executedItems', 'quantityIssuesItems'));
    }
}
