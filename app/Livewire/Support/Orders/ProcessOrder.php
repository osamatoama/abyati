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
        $executedItems = $this->order->items->filter(fn ($item) => $item->isCompleted());
        $toExecuteItems = $this->order->items->filter(fn ($item) => ! $item->isCompleted() && ! $item->isQuantityIssues());
        $quantityIssuesItems = $this->order->items->filter(fn ($item) => $item->isQuantityIssues());

        return view('livewire.support.orders.process-order', compact('executedItems', 'toExecuteItems', 'quantityIssuesItems',));
    }
}
