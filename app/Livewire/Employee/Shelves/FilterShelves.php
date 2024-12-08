<?php

namespace App\Livewire\Employee\Shelves;

use Livewire\Component;
use App\Models\Warehouse;
use Livewire\Attributes\Url;
use Livewire\Attributes\Locked;

class FilterShelves extends Component
{
    #[Locked]
    public array $warehouses = [];

    #[Locked]
    public array $employees = [];

    // #[Url]
    public ?array $warehouse_ids = [];

    public function mount()
    {
        $this->warehouses = Warehouse::pluck('name', 'id')->toArray();

        $this->dispatch('shelf-filters-mounted');
    }

    public function render()
    {
        return view('livewire.employee.shelves.filter-shelves');
    }

    public function apply()
    {
        $this->validate();

        $this->dispatch('shelf-filters-applied', [
            'filters' => $this->getFilters(),
            'refresh_url' => route('employee.shelves.index', $this->getFilters()),
        ]);
    }

    public function resetFilters()
    {
        $this->reset([
            'warehouse_ids',
        ]);

        $this->dispatch('shelf-filters-reset', [
            'filters' => [],
            'refresh_url' => route('employee.shelves.index'),
        ]);
    }

    protected function rules()
    {
        return [
            'warehouse_ids' => ['array'],
            'warehouse_ids.*' => ['nullable', 'exists:warehouses,id'],
        ];
    }

    protected function validationAttributes()
    {
        return [
            'warehouse_ids' => __('employee.shelves.attributes.warehouse'),
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
            'warehouse_ids' => $this->warehouse_ids,
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
