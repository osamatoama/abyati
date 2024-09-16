<?php

namespace App\Livewire\Employee\Orders;

use Livewire\Component;
use Livewire\Attributes\On;

class ExportOrders extends Component
{
    public array $filters = [];

    public function mount()
    {
        $this->filters = query();
    }

    public function render()
    {
        return view('livewire.employee.orders.export-orders');
    }

    #[On('order-filters-applied', 'order-filters-reset')]
    public function updateFilters($data)
    {
        $this->filters = $data['filters'] ?? [];
    }
}
