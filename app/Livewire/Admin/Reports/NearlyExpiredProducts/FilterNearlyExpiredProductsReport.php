<?php

namespace App\Livewire\Admin\Reports\NearlyExpiredProducts;

use Livewire\Component;
use App\Models\Warehouse;
use Livewire\Attributes\Url;
use Livewire\Attributes\Locked;

class FilterNearlyExpiredProductsReport extends Component
{
    #[Locked]
    public array $warehouses = [];

    #[Url]
    public ?int $warehouse_id = null;

    public function mount()
    {
        $this->warehouses = Warehouse::active()->pluck('name', 'id')->toArray();

        $this->dispatch('report-filters-mounted');
    }

    public function render()
    {
        return view('livewire.admin.reports.nearly-expired-products.filter-nearly-expired-products-report');
    }

    public function apply()
    {
        $this->validate();

        $this->dispatch('report-filters-applied', [
            'filters' => $this->getFilters(),
            'refresh_url' => route('admin.reports.nearly-expired-products.index', $this->getFilters()),
        ]);
    }

    protected function rules()
    {
        return [
            'warehouse_id' => ['required', 'exists:warehouses,id'],
        ];
    }

    protected function validationAttributes()
    {
        return [
            'warehouse_id' => __('admin.reports.nearly_expired_products.filters.warehouse_id'),
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
