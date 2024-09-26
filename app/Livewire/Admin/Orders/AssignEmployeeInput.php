<?php

namespace App\Livewire\Admin\Orders;

use App\Models\Order;
use Livewire\Component;
use App\Models\Employee;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;
use Illuminate\Support\Collection;
use App\Services\Orders\Fulfillment\Admin\AssignOrderToEmployee;

class AssignEmployeeInput extends Component
{
    #[Locked]
    public Order $order;

    public Collection $employees;

    public ?int $employee_id = null;

    public ?bool $enable_assign = false;

    public function mount()
    {
        $this->employees = Employee::query()
            ->active()
            ->where('branch_id', $this->order->branch_id)
            ->pluck('name', 'id');
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

        (new AssignOrderToEmployee(
            order: $this->order, 
            employeeId: $this->employee_id
        ))->execute();

        $this->dispatch('order-employee-assigned', [
            'message' => __('admin.orders.messages.employee_assigned'),
        ]);
    }

    protected function rules()
    {
        return [
            'employee_id' => [
                'required',
                Rule::exists('employees', 'id')
                    ->where('id', '!=', $this->order->employee_id)
                    ->where('branch_id', $this->order->branch_id)
                    ->where('active', true),
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
