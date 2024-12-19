<?php

namespace App\Livewire\Admin\Reports\OutOfStockProducts;

use Livewire\Component;
use App\Models\Employee;
use App\Models\Warehouse;
use App\Enums\EmployeeRole;
use Livewire\Attributes\Url;
use Livewire\Attributes\Locked;

class FilterOutOfStockProductsReport extends Component
{
    #[Locked]
    public array $warehouses = [];

    #[Locked]
    public array $employees = [];

    #[Url]
    public ?int $warehouse_id = null;

    #[Url]
    public ?int $employee_id = null;

    public function mount()
    {
        $this->warehouses = Warehouse::active()->pluck('name', 'id')->toArray();
        $this->employees = Employee::role(EmployeeRole::STOCKTAKING)->pluck('name', 'id')->toArray();

        $this->dispatch('report-filters-mounted');
    }

    public function render()
    {
        return view('livewire.admin.reports.out-of-stock-products.filter-out-of-stock-products-report');
    }

    public function apply()
    {
        $this->validate();

        $this->dispatch('report-filters-applied', [
            'filters' => $this->getFilters(),
            'refresh_url' => route('admin.reports.out-of-stock-products.index', $this->getFilters()),
        ]);
    }

    protected function rules()
    {
        return [
            'warehouse_id' => ['required', 'exists:warehouses,id'],
            'employee_id' => ['nullable', 'exists:employees,id'],
        ];
    }

    protected function validationAttributes()
    {
        return [
            'warehouse_id' => __('admin.reports.out_of_stock_products.filters.warehouse_id'),
            'employee_id' => __('admin.reports.out_of_stock_products.filters.employee_id'),
        ];
    }

    protected function messages()
    {
        return [
            //
        ];
    }

    private function getFilters(): array
    {
        $filters = [
            'warehouse_id' => $this->warehouse_id,
            'employee_id' => $this->employee_id,
        ];

        $params = [];

        foreach ($filters as $key => $value) {
            if (! empty($value)) {
                $params[$key] = $value;
            }
        }

        return $params;
    }
}
