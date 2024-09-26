<?php

namespace App\Livewire\Admin\Orders;

use App\Models\Order;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Enums\OrderCompletionStatus;

class OrderTabs extends Component
{
    public array $tabs;

    public array $filters = [];

    public function render()
    {
        $this->tabs = $this->getTabs();

        return view('livewire.admin.orders.order-tabs');
    }

    private function getTabs(): array
    {
        $hasSingleActiveTab = count($this->filters['completion_statuses'] ?? []) == 1;

        $ordersQuery = Order::query()
            ->filter(
                appendedFilters: $this->filters
            );

        $tabs = [
            'all' => [
                'title' =>__('globals.all'),
                'url' => route('admin.orders.index'),
                // 'active' => empty($this->filters['completion_statuses'][0] ?? []),
                'active' => 0,
                'count' => (clone $ordersQuery)->count(),
            ],
        ];

        foreach (OrderCompletionStatus::cases() as $status) {
            $tabs[$status->value] = [
                'title' => $status->trans(),
                'url' => route('admin.orders.index') . '?completion_statuses[0]=' . $status->value,
                // 'active' => $hasSingleActiveTab && ($this->filters['completion_statuses'][0] ?? null === $status->value),
                'active' => 0,
                'count' => (clone $ordersQuery)->where('completion_status', $status)->count(),
            ];
        }

        return $tabs;
    }

    #[On('order-filters-applied', 'order-filters-reset')]
    public function updateFilters($data)
    {
        $this->filters = $data['filters'] ?? [];
    }
}
