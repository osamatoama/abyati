<?php

namespace App\Livewire\Admin\Reports\EmployeePerformance;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Employee;
use Livewire\Attributes\Url;
use Livewire\Attributes\Locked;

class FilterEmployeePerformanceReport extends Component
{
    #[Locked]
    public array $employees = [];

    public $date;

    #[Url]
    public $from_date = '';

    #[Url]
    public $to_date = '';

    #[Url]
    public ?int $employee_id = null;

    public function mount()
    {
        $this->employees = Employee::pluck('name', 'id')->toArray();

        $this->dispatch('report-filters-mounted');
    }

    public function render()
    {
        return view('livewire.admin.reports.employee-performance.filter-employee-performance-report');
    }

    public function apply()
    {
        $this->validate();

        ['from' => $fromDate, 'to' => $toDate] = core()->getDateFromFlatpickrRange($this->date);
        $this->from_date = !empty(trim($fromDate)) ? Carbon::parse($fromDate)->format('Y-m-d') : null;
        $this->to_date = !empty(trim($toDate)) ? Carbon::parse($toDate)->format('Y-m-d') : null;

        $this->dispatch('report-filters-applied', [
            'filters' => $this->getFilters(),
            'refresh_url' => route('admin.reports.employee-performance.index', $this->getFilters()),
        ]);
    }

    protected function rules()
    {
        return [
            'from_date' => ['nullable', 'date', 'before_or_equal:today'],
            'to_date' => ['nullable', 'date', 'before_or_equal:today', 'after_or_equal:from_date'],
            'employee_id' => ['required', 'exists:employees,id'],
        ];
    }

    protected function validationAttributes()
    {
        return [
            'from_date' => __('global.date'),
            'to_date' => __('global.date'),
            'employee_id' => __('admin.reports.employee_performance.filters.employee_id'),
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
            'employee_id' => $this->employee_id,
            'from_date' => $this->from_date,
            'to_date' => $this->to_date,
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
