<?php

namespace App\Livewire\Admin\Orders;

use App\Models\Order;
use Livewire\Component;
use App\Models\Employee;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;
use Illuminate\Support\Collection;

class AssignEmployeeInput extends Component
{
    #[Locked]
    public Order $order;

    public Collection $employees;

    public ?int $employee_id = null;

    public ?bool $enable_assign = false;

    public function mount()
    {
        /**
         * TODO: Add branch_id to the query
         */
        $this->employees = Employee::active()->pluck('name', 'id');
    }

    public function render()
    {
        $this->employee_id = $this->order->employee_id;
        $this->enable_assign = ! $this->order->isCompleted();

        return view('livewire.admin.orders.assign-employee-input');
    }

    public function updatedEmployeeId()
    {
        $this->assign();
    }

    private function assign()
    {
        $this->validate();

        $this->order->update([
            'employee_id' => $this->employee_id,
        ]);

        $this->dispatch('order-employee-assigned', [
            'message' => __('admin.orders.messages.employee_assigned'),
        ]);
    }

    protected function rules()
    {
        return [
            'employee_id' => [
                'required',
                Rule::exists('employees', 'id')->where('active', true),
            ],
        ];
    }

    protected function validationAttributes()
    {
        return [
            'employee_id' => __('admin.orders.attributes.employee'),
        ];
    }
}