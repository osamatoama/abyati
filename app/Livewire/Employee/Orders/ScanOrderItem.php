<?php

namespace App\Livewire\Employee\Orders;

use Livewire\Component;
use App\Models\OrderItem;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;
use App\Enums\OrderCompletionStatus;
use App\Enums\OrderItemCompletionStatus;

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

        $this->item->increment('executed_quantity');

        $this->reset('scanned_barcode');

        if ($this->item->isPartiallyExecuted()) {
            $this->item->update([
                'completion_status' => OrderItemCompletionStatus::PROCESSING,
            ]);

            return;
        }

        if ($this->item->isExecuted()) {
            $this->item->update([
                'completion_status' => OrderItemCompletionStatus::COMPLETED,
            ]);

            if ($this->item->order->isExecuted()) {
                $this->item->order->update([
                    'completion_status' => OrderCompletionStatus::COMPLETED,
                ]);

                $this->item->order->executionHistories()->create([
                    'employee_id' => auth('employee')->id(),
                    'status' => OrderCompletionStatus::COMPLETED,
                ]);
            }

            $this->dispatch('order-item-executed', [
                'order_item_id' => $this->item->id,
                'message' => __('employee.orders.messages.item_executed'),
            ]);

            return;
        }
    }

    public function rules(): array
    {
        return [
            'scanned_barcode' => [
                'required',
                Rule::in([$this->item->variant->barcode]),
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
