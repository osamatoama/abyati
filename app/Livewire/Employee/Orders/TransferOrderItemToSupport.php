<?php

namespace App\Livewire\Employee\Orders;

use Livewire\Component;
use App\Models\Employee;
use App\Models\OrderItem;
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\DB;
use App\Enums\OrderCompletionStatus;
use App\Enums\OrderItemCompletionStatus;

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

        DB::transaction(function () {
            $this->item->update([
                'completion_status' => OrderItemCompletionStatus::QUANTITY_ISSUES,
            ]);

            $this->item->order->update([
                'status' => OrderCompletionStatus::QUANTITY_ISSUES,
            ]);

            $this->item->order->executionHistories()->create([
                'employee_id' => auth('employee')->id(),
                'status' => OrderCompletionStatus::QUANTITY_ISSUES,
            ]);

            if (filled($this->employee_note)) {
                $this->item->notes()->create([
                    'author_id' => auth('employee')->id(),
                    'author_type' => Employee::class,
                    'content' => $this->employee_note,
                ]);
            }
        });

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
