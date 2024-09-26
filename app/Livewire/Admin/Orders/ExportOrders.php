<?php

namespace App\Livewire\Admin\Orders;

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
        return view('livewire.admin.orders.export-orders');
    }

    #[On('order-filters-applied', 'order-filters-reset')]
    public function updateFilters($data)
    {
        $this->filters = $data['filters'] ?? [];
    }
}
