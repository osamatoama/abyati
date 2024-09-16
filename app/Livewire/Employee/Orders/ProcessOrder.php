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

    #[On('order-item-executed')]
    public function render()
    {
        $executedItems = $this->order->items->filter(fn ($item) => $item->isExecuted());
        $toExecuteItems = $this->order->items->filter(fn ($item) => ! $item->isExecuted() && ! $item->isQuantityIssues());
        $quantityIssuesItems = $this->order->items->filter(fn ($item) => $item->isQuantityIssues());

        return view('livewire.employee.orders.process-order', compact('executedItems', 'toExecuteItems', 'quantityIssuesItems',));
    }
}
