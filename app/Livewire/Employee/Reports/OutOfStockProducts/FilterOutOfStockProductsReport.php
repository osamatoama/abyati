<?php

namespace App\Livewire\Employee\Reports\OutOfStockProducts;

use App\Models\Shelf;
use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\Attributes\Locked;

class FilterOutOfStockProductsReport extends Component
{
    #[Locked]
    public array $aisles = [];

    #[Locked]
    public array $shelves = [];

    #[Url(except: '')]
    public ?string $aisle = '';

    #[Url(except: '')]
    public ?string $shelf_id = '';

    public function mount()
    {
        if (filled($this->getFilters())) {
            $this->apply();
        }

        $this->dispatch('report-filters-mounted');
    }

    public function render()
    {
        $this->aisles = Shelf::select('aisle')
            ->distinct('aisle')
            ->whereHas('employees', function ($q) {
                $q->where('employees.id', auth('employee')->id());
            })
            ->get()
            ->pluck('aisle', 'aisle')
            ->toArray();

        $this->shelves = Shelf::select('id', 'warehouse_id', 'name')
            ->whereHas('employees', function ($q) {
                $q->where('employees.id', auth('employee')->id());
            })
            ->when($this->aisle, function ($q) {
                return $q->where('aisle', $this->aisle);
            })
            ->pluck('name', 'id')
            ->toArray();

        return view('livewire.employee.reports.out-of-stock-products.filter-out-of-stock-products-report');
    }

    public function updated($property)
    {
        if ($property == 'aisle') {
            $this->shelf_id = '';
        }

        $this->apply();
    }

    public function apply()
    {
        $this->validate();

        $this->dispatch('report-filters-applied', [
            'filters' => $this->getFilters(),
            'refresh_url' => route('employee.reports.out-of-stock-products.index', $this->getFilters()),
        ]);
    }

    protected function rules()
    {
        return [
            'aisle' => ['nullable', 'string'],
            'shelf_id' => ['nullable', 'exists:shelves,id'],
        ];
    }

    protected function validationAttributes()
    {
        return [
            'aisle' => __('employee.reports.out_of_stock_products.filters.aisle'),
            'shelf_id' => __('employee.reports.out_of_stock_products.filters.shelf_id'),
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
