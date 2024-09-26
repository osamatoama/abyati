<?php

namespace App\Livewire\Admin\Products;

use App\Models\Store;
use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\Attributes\Locked;

class FilterProducts extends Component
{
    #[Locked]
    public array $stores = [];

    #[Locked]
    public array $employees = [];

    #[Url]
    public ?array $store_ids = [];

    public function mount()
    {
        $this->stores = Store::pluck('name', 'id')->toArray();

        $this->dispatch('product-filters-mounted');
    }

    public function render()
    {
        return view('livewire.admin.products.filter-products');
    }

    public function apply()
    {
        $this->validate();

        $this->dispatch('product-filters-applied', [
            'filters' => $this->getFilters(),
            'refresh_url' => route('admin.products.index', $this->getFilters()),
        ]);
    }

    public function resetFilters()
    {
        $this->reset([
            'store_ids',
        ]);

        $this->dispatch('product-filters-reset', [
            'filters' => [],
            'refresh_url' => route('admin.products.index'),
        ]);
    }

    protected function rules()
    {
        return [
            'store_ids' => ['array'],
            'store_ids.*' => ['nullable', 'exists:stores,id'],
        ];
    }

    protected function validationAttributes()
    {
        return [
            'store_ids' => __('admin.products.pull_form.store'),
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
            'store_ids' => $this->store_ids,
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
