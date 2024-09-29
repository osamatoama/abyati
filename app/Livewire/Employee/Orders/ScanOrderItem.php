<?php

namespace App\Livewire\Employee\Orders;

use Livewire\Component;
use App\Models\OrderItem;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;
use App\Services\Orders\Fulfillment\Employee\ScanOrderItem as ScanOrderItemService;

class ScanOrderItem extends Component
{
    #[Locked]
    public OrderItem $item;

    public bool $enable = false;

    public ?string $scanned_barcode = null;

    public function render()
    {
        $this->enable = ! $this->item->isExecuted();

        return view('livewire.employee.orders.scan-order-item');
    }

    public function scan()
    {
        $this->validate();

        $scanService = new ScanOrderItemService(
            item: $this->item
        );

        $scanService->execute();

        $this->dispatch('order-item-scanned', [
            'order_item_id' => $this->item->id,
        ]);

        if ($scanService->executionCompleted) {
            $this->dispatch('order-item-executed', [
                'order_item_id' => $this->item->id,
                'message' => __('employee.orders.messages.item_executed'),
            ]);
        }

        $this->reset('scanned_barcode');
    }

    public function rules(): array
    {
        return [
            'scanned_barcode' => [
                'required',
                Rule::in([$this->item->barcode]),
            ],
        ];
    }

    protected function validationAttributes()
    {
        return [
            'scanned_barcode' => __('employee.products.attributes.barcode'),
        ];
    }

    protected function messages()
    {
        return [
            'scanned_barcode.in' => __('employee.orders.errors.invalid_barcode'),
        ];
    }
}
