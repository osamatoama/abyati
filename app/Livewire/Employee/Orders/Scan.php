<?php

namespace App\Livewire\Employee\Orders;

use App\Models\Order;
use App\Models\OrderItem;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;
use App\Services\Orders\Fulfillment\Employee\ScanOrderItem as ScanOrderItemService;

class Scan extends Component
{
    #[Locked]
    public Order $order;

    public bool $enable = false;

    public ?string $scanned_barcode = null;

    public ?OrderItem $scanned_item = null;

    public function render()
    {
        $this->enable = ! $this->order->isExecuted();

        return view('livewire.employee.orders.scan');
    }

    public function scan()
    {
        logError('Scan: ', $this->scanned_barcode);

        $this->reset('scanned_item');

        $this->resetErrorBag();

        $this->validate();

        $item = $this->order->items->firstWhere('barcode', $this->scanned_barcode);

        $scanService = new ScanOrderItemService(
            item: $item
        );

        $scanService->execute();

        $this->scanned_item = $item;

        $this->dispatch('order-scanned', [
            'order_item_id' => $item->id,
        ]);

        if ($this->order->isExecuted()) {
            $this->dispatch('order-executed', [
                'message' => __('employee.orders.messages.order_executed'),
            ]);
        }

        $this->reset('scanned_barcode');

        logError('Scan completed');
    }

    private function getAvailableBarcodesToScan(): array
    {
        return $this->order->items
            ->filter(fn($i) => ! $i->isExecuted())
            ->map(fn($i) => $i->barcode)
            ->values()
            ->toArray();
    }

    public function rules(): array
    {
        return [
            'scanned_barcode' => [
                'required',
                Rule::in($this->getAvailableBarcodesToScan()),
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
