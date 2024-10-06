<?php

namespace App\Livewire\Support\Orders;

use Livewire\Component;
use App\Models\OrderItem;
use Livewire\Attributes\Locked;
use App\Services\Orders\Fulfillment\Support\CompleteOrderItem as CompleteOrderItemService;

class CompleteOrderItem extends Component
{
    #[Locked]
    public OrderItem $item;

    public bool $enable = false;

    public function render()
    {
        $this->enable = ! $this->item->isExecuted();

        return view('livewire.support.orders.complete-order-item');
    }

    public function complete()
    {
        (new CompleteOrderItemService(
            item: $this->item,
        ))->execute();

        $this->dispatch('order-item-completed', [
            'order_item_id' => $this->item->id,
            'message' => __('support.orders.messages.item_completed'),
        ]);
    }
}
