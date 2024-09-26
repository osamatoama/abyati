<?php

namespace App\Livewire\Admin\Branches;

use App\Models\Store;
use App\Models\Branch;
use Livewire\Component;
use Illuminate\Support\Arr;
use Livewire\Attributes\Locked;
use Illuminate\Support\Collection;

class CreateBranchForm extends Component
{
    #[Locked]
    public Collection $stores;

    public ?string $name = null;

    public array $order_statuses = [];

    public function render()
    {
        $this->stores = Store::select('id', 'name')
            ->with([
                'orderStatuses' => fn ($query) => $query->whereNotNull('slug')->select('id', 'store_id', 'name'),
            ])
            ->get();

        return view('livewire.admin.branches.create-branch-form');
    }

    public function save()
    {
        $this->validate();

        $syncedOrderStatuses = Arr::map(
            array: array_flip($this->order_statuses),
            callback: fn($storeId, $orderStatusId) => ['store_id' => $storeId],
        );

        $branch = Branch::create([
            'name' => $this->name,
        ]);

        $branch->orderStatuses()->sync($syncedOrderStatuses);

        $this->dispatch('branch-created', [
            'message' => __('admin.branches.messages.created'),
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
