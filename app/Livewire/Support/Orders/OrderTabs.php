<?php

namespace App\Livewire\Support\Orders;

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

        return view('livewire.support.orders.order-tabs');
    }

    private function getTabs(): array
    {
        $hasSingleActiveTab = count($this->filters['completion_statuses'] ?? []) == 1;

        $ordersQuery = Order::query()
            ->branchMine()
            ->whereHas('executionHistories', function ($q) {
                $q->where('status', OrderCompletionStatus::QUANTITY_ISSUES);
            })
            ->filter(
                appendedFilters: $this->filters
            );

        $tabs = [
            'all' => [
                'title' =>__('globals.all'),
                'url' => route('support.orders.index'),
                // 'active' => empty($this->filters['completion_statuses'][0] ?? []),
                'active' => 0,
                'count' => (clone $ordersQuery)->count(),
            ],
        ];

        foreach (OrderCompletionStatus::supportCases() as $status) {
            $tabs[$status->value] = [
                'title' => $status->trans(),
                'url' => route('support.orders.index') . '?completion_statuses[0]=' . $status->value,
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
