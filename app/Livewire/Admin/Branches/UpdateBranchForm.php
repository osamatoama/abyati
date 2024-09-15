<?php

namespace App\Livewire\Admin\Branches;

use App\Models\Store;
use App\Models\Branch;
use Livewire\Component;
use Illuminate\Support\Arr;
use Livewire\Attributes\Locked;
use Illuminate\Support\Collection;

class UpdateBranchForm extends Component
{
    #[Locked]
    public Branch $branch;

    #[Locked]
    public Collection $stores;

    public string $name;

    public array $order_statuses = [];

    public function render()
    {
        $this->stores = Store::select('id', 'name')
            ->with([
                'orderStatuses' => fn ($query) => $query->whereNotNull('slug')->select('id', 'store_id', 'name'),
            ])
            ->get();

        $this->branch->load('orderStatuses');

        $this->name = $this->branch->name;

        foreach ($this->stores as $store) {
            $this->order_statuses[$store->id] = $this->branch
                ->orderStatuses
                ->firstWhere('pivot.store_id', $store->id)
                ?->id;
        }

        return view('livewire.admin.branches.update-branch-form');
    }

    public function save()
    {
        $this->validate();

        $syncedOrderStatuses = Arr::map(
            array: array_flip($this->order_statuses),
            callback: fn($storeId, $orderStatusId) => ['store_id' => $storeId],
        );

        $this->branch->update([
            'name' => $this->name,
        ]);

        $this->branch->orderStatuses()->sync($syncedOrderStatuses);

        $this->dispatch('branch-updated', [
            'message' => __('admin.branches.messages.updated'),
            'redirect_url' => route('admin.branches.index'),
        ]);
    }

    protected function rules()
    {
        return [
            'name' => 'required|string',
            'order_statuses' => 'array',
            'order_statuses.*' => 'nullable|exists:order_statuses,id',
        ];
    }

    protected function validationAttributes()
    {
        return [
            'name' => __('admin.branches.attributes.name'),
            'order_statuses' => __('admin.branches.attributes.related_order_statuses'),
        ];
    }
}
