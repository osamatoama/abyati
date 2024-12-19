<?php

namespace App\Livewire\Employee\Orders;

use App\Models\Order;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Locked;

class ProcessOrder extends Component
{
    #[Locked]
    public Order $order;

    #[On('order-item-scanned')]
    #[On('order-item-transferred')]
    #[On('order-scanned')]
    public function render()
    {
        // $executedItems = $this->order->items->filter(fn ($item) => $item->isCompleted());
        // $toExecuteItems = $this->order->items->filter(fn ($item) => ! $item->isCompleted() && ! $item->isQuantityIssues());
        // $quantityIssuesItems = $this->order->items->filter(fn ($item) => $item->isQuantityIssues());

        $executedItems = $this->order->decomposedItems->filter(fn ($item) => $item->isCompleted());
        $toExecuteItems = $this->order->decomposedItems->filter(fn ($item) => ! $item->isCompleted() && ! $item->isQuantityIssues());
        $quantityIssuesItems = $this->order->decomposedItems->filter(fn ($item) => $item->isQuantityIssues());

        return view('livewire.employee.orders.process-order', compact('executedItems', 'toExecuteItems', 'quantityIssuesItems',));
    }
}
