<?php

namespace App\Livewire\Admin\Reports\EmployeePerformance;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\OrderExecution;

class EmployeePerformanceReportTabs extends Component
{
    public array $tabs;

    public array $filters = [];

    public bool $enabled = false;

    public function render()
    {
        $this->enabled = ! empty($this->filters['employee_id'] ?? null);
        $this->tabs = $this->getTabs();

        return view('livewire.admin.reports.employee-performance.employee-performance-report-tabs');
    }

    private function getTabs(): array
    {
        $hasSingleActiveTab = count($this->filters['completion_statuses'] ?? []) == 1;

        $orderExecutionsQuery = OrderExecution::query()
            ->filter(
                appendedFilters: $this->filters
            );

        $allOrdersCount = $orderExecutionsQuery->count();
        $completedOrdersCount = $orderExecutionsQuery->filter(
                appendedFilters: ['status' => 'completed']
            )
            ->count();
        $reassignedOrdersCount = $orderExecutionsQuery->filter(
                appendedFilters: ['status' => 'reassigned']
            )
            ->count();

        $efficiency = null;
        if ($allOrdersCount > 0) {
            $efficiency = round(($completedOrdersCount / $allOrdersCount) * 100, 1);
        }

        $lateness = null;
        if ($allOrdersCount > 0) {
            $lateness = round(($reassignedOrdersCount / $allOrdersCount) * 100, 1);
        }

        $tabs = [
            'all' => [
                'title' => 'عدد الطلبات',
                'url' => route('admin.orders.index'),
                // 'active' => empty($this->filters['completion_statuses'][0] ?? []),
                'active' => 0,
                'count' => $allOrdersCount,
            ],
            'completed' => [
                'title' => 'الطلبات المكتملة',
                'url' => route('admin.orders.index'),
                // 'active' => empty($this->filters['completion_statuses'][0] ?? []),
                'active' => 0,
                'count' => $completedOrdersCount,
            ],
            'reassigned' => [
                'title' => 'الطلبات المتأخرة',
                'url' => route('admin.orders.index'),
                // 'active' => empty($this->filters['completion_statuses'][0] ?? []),
                'active' => 0,
                'count' => $reassignedOrdersCount,
            ],
            'efficiency' => [
                'title' => 'نسبة الكفاءة',
                'url' => route('admin.orders.index'),
                // 'active' => empty($this->filters['completion_statuses'][0] ?? []),
                'active' => 0,
                'count' => ! is_null($efficiency) ? '%' . $efficiency : '---',
            ],
            'lateness' => [
                'title' => 'نسبة التأخير',
                'url' => route('admin.orders.index'),
                // 'active' => empty($this->filters['completion_statuses'][0] ?? []),
                'active' => 0,
                'count' => ! is_null($lateness) ? '%' . $lateness : '---',
            ],
        ];

        // foreach (OrderCompletionStatus::cases() as $status) {
        //     $tabs[$status->value] = [
        //         'title' => $status->trans(),
        //         'url' => route('admin.orders.index') . '?completion_statuses[0]=' . $status->value,
        //         // 'active' => $hasSingleActiveTab && ($this->filters['completion_statuses'][0] ?? null === $status->value),
        //         'active' => 0,
        //         'count' => (clone $ordersQuery)->where('completion_status', $status)->count(),
        //     ];
        // }

        return $tabs;
    }

    #[On('report-filters-applied', 'report-filters-reset')]
    public function updateFilters($data)
    {
        $this->filters = $data['filters'] ?? [];
    }
}
