<?php

namespace App\Livewire\Admin\Orders;

use Carbon\Carbon;
use Livewire\Component;
use App\Jobs\Salla\Pull\Orders\PullOrdersJob;

class PullOrdersForm extends Component
{
    public $date;

    public $from_date = '';

    public $to_date = '';

    public function render()
    {
        return view('livewire.admin.orders.pull-orders-form');
    }

    public function pullOrders()
    {
        /**
         * TODO: add flight request to Salla to get number of orders
         */

        $range = core()->getDateFromFlatpickrRange($this->date);
        $this->from_date = $range['from'];
        $this->to_date = $range['to'];

        $validated = $this->validate();
        $filters['from_date'] = Carbon::parse($validated['from_date'])->format('d-m-Y');
        $filters['to_date'] = Carbon::parse($validated['to_date'])->addDay()->format('d-m-Y');

        dispatch(new PullOrdersJob(
            user: currentUser(),
            filters: $filters,
        ));

        $this->dispatch('pull-orders-started', __('admin.orders.messages.pull_started'));
    }

    protected function rules()
    {
        return [
            'from_date' => ['required', 'date', 'before_or_equal:today'],
            'to_date' => ['required', 'date', 'before_or_equal:today', 'after_or_equal:from_date'],
        ];
    }

    protected function validationAttributes()
    {
        return [
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
}
