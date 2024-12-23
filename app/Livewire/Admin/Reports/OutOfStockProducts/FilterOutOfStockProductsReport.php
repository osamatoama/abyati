<?php

namespace App\Livewire\Admin\Reports\OutOfStockProducts;

use App\Models\Shelf;
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

    #[Locked]
    public array $aisles = [];

    #[Locked]
    public array $shelves = [];

    #[Url]
    public ?int $warehouse_id = null;

    #[Url]
    public ?int $employee_id = null;

    #[Url]
    public ?string $aisle = null;

    #[Url]
    public ?int $shelf_id = null;

    public function mount()
    {
        $this->warehouses = Warehouse::active()->pluck('name', 'id')->toArray();
        $this->employees = Employee::role(EmployeeRole::STOCKTAKING)->pluck('name', 'id')->toArray();

        $this->dispatch('report-filters-mounted');
    }

    public function render()
    {
        $this->aisles = Shelf::select('aisle')
            ->distinct('aisle')
            ->when($this->warehouse_id, function ($q) {
                return $q->where('warehouse_id', $this->warehouse_id);
            })
            ->when($this->employee_id, function ($q) {
                return $q->whereHas('employees', function ($q) {
                    $q->where('employees.id', $this->employee_id);
                });
            })
            ->get()
            ->pluck('aisle', 'aisle')
            ->toArray();

        $this->shelves = Shelf::select('id', 'warehouse_id', 'name')
            ->when($this->warehouse_id, function ($q) {
                return $q->where('warehouse_id', $this->warehouse_id);
            })
            ->when($this->aisle, function ($q) {
                return $q->where('aisle', $this->aisle);
            })
            ->pluck('name', 'id')
            ->toArray();

        return view('livewire.admin.reports.out-of-stock-products.filter-out-of-stock-products-report');
    }

    public function updated($property)
    {
        if ($property == 'warehouse_id') {
            $this->employee_id = null;
            $this->aisle = null;
            $this->shelf_id = null;
        }

        $this->apply();
    }

    public function apply()
    {
        $this->validate();

        if ($this->shelf_id && empty($this->aisle)) {
            $this->aisle = Shelf::find($this->shelf_id)->aisle;
        }

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
            'aisle' => ['nullable', 'string'],
            'shelf_id' => ['nullable', 'exists:shelves,id'],
        ];
    }

    protected function validationAttributes()
    {
        return [
            'warehouse_id' => __('admin.reports.out_of_stock_products.filters.warehouse_id'),
            'employee_id' => __('admin.reports.out_of_stock_products.filters.employee_id'),
            'aisle' => __('admin.reports.out_of_stock_products.filters.aisle'),
            'shelf_id' => __('admin.reports.out_of_stock_products.filters.shelf_id'),
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
            'aisle' => $this->aisle,
            'shelf_id' => $this->shelf_id,
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
