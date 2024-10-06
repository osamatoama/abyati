<?php

namespace App\Livewire\Employee\Orders;

use Livewire\Component;
use App\Models\OrderItem;
use Livewire\Attributes\Locked;
use App\Services\Orders\Fulfillment\Employee\TransferOrderItemToSupport as TransferOrderItemToSupportService;

class TransferOrderItemToSupport extends Component
{
    #[Locked]
    public OrderItem $item;

    public bool $enable = false;

    public ?string $employee_note = null;

    public function render()
    {
        $this->enable = ! $this->item->isExecuted();

        return view('livewire.employee.orders.transfer-order-item-to-support');
    }

    public function transferToSupport()
    {
        $this->validate();

        (new TransferOrderItemToSupportService(
            item: $this->item,
            note: $this->employee_note,
        ))->execute();

        $this->dispatch('order-item-transferred', [
            'order_item_id' => $this->item->id,
            'message' => __('employee.orders.messages.item_transferred_to_support'),
        ]);
    }

    public function rules(): array
    {
        return [
            'employee_note' => ['nullable', 'string', 'max:1000'],
        ];
    }

    protected function validationAttributes()
    {
        return [
            'employee_note' => __('employee.orders.items.attributes.employee_note'),
        ];
    }
}
