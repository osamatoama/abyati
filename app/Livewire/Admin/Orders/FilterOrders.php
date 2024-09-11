<?php

namespace App\Livewire\Admin\Orders;

use Carbon\Carbon;
use App\Models\Store;
use Livewire\Component;
use App\Models\Employee;
use Livewire\Attributes\Url;
use Livewire\Attributes\Locked;

class FilterOrders extends Component
{
    #[Locked]
    public array $stores = [];

    #[Locked]
    public array $employees = [];

    #[Url]
    public ?array $store_ids = [];

    public $date;

    #[Url]
    public $from_date = '';

    #[Url]
    public $to_date = '';

    #[Url]
    public array $completion_statuses = [];

    #[Url]
    public ?string $is_assigned = '';

    #[Url]
    public ?array $employee_ids = [];

    public function mount()
    {
        $this->stores = Store::pluck('name', 'id')->toArray();
        $this->employees = Employee::pluck('name', 'id')->toArray();

        $this->dispatch('order-filters-mounted');
    }

    public function render()
    {
        return view('livewire.admin.orders.filter-orders');
    }

    public function apply()
    {
        // $validated = $this->validate();

        ['from' => $fromDate, 'to' => $toDate] = core()->getDateFromFlatpickrRange($this->date);
        $this->from_date = !empty(trim($fromDate)) ? Carbon::parse($fromDate)->format('Y-m-d') : null;
        $this->to_date = !empty(trim($toDate)) ? Carbon::parse($toDate)->format('Y-m-d') : null;

        $this->dispatch('order-filters-applied', [
            'filters' => $this->getFilters(),
            'refresh_url' => route('admin.orders.index', $this->getFilters()),
        ]);
    }

    public function resetFilters()
    {
        $this->reset([
            'store_ids',
            'from_date',
            'to_date',
            'completion_statuses',
            'is_assigned',
            'employee_ids',
        ]);

        $this->dispatch('order-filters-reset', [
            'filters' => [],
            'refresh_url' => route('admin.orders.index'),
        ]);
    }

    protected function rules()
    {
        return [
            // 'store_id' => ['required', 'exists:stores,id'],
            'from_date' => ['required', 'date', 'before_or_equal:today'],
            'to_date' => ['required', 'date', 'before_or_equal:today', 'after_or_equal:from_date'],
        ];
    }

    protected function validationAttributes()
    {
        return [
            // 'store_id' => __('admin.orders.pull_form.store'),
            'from_date' => __('admin.orders.pull_form.from_date'),
            'to_date' => __('admin.orders.pull_form.to_date'),
        ];
    }

    protected function messages()
    {
        return [
            'from_date.before_or_equal' => __('admin.orders.pull_form.errors.from_date_should_be_before_now'),
            'to_date.before_or_equal' => __('admin.orders.pull_form.errors.to_date_should_be_before_now'),
            'to_date.after_or_equal' => __('admin.orders.pull_form.errors.to_date_should_be_after_from_date'),
        ];
    }

    private function getFilters(): array
    {
        $filters = [
            'store_ids' => $this->store_ids,
            'employee_ids' => $this->employee_ids,
            'completion_statuses' => $this->completion_statuses,
            'from_date' => $this->from_date,
            'to_date' => $this->to_date,
            'is_assigned' => $this->is_assigned,
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
