<?php

namespace App\Livewire\Support\Orders;

use Carbon\Carbon;
use App\Models\Store;
use Livewire\Component;
use Livewire\Attributes\Locked;
use App\Jobs\Salla\Pull\Orders\PullOrdersJob;

class PullOrdersForm extends Component
{
    public ?string $store_id = '';

    public $date;

    public $from_date = '';

    public $to_date = '';

    #[Locked]
    public array $stores = [];

    public function mount()
    {
        $this->stores = Store::pluck('name', 'id')->toArray();
    }

    public function render()
    {
        return view('livewire.support.orders.pull-orders-form');
    }

    public function pullOrders()
    {
        /**
         * TODO: add flight request to Salla to get number of orders
         */
        $store = Store::find($this->store_id);
        [$this->from_date, $this->to_date] = core()->getDateFromFlatpickrRange($this->date);

        $validated = $this->validate();
        $filters['from_date'] = Carbon::parse($validated['from_date'])->format('d-m-Y');
        $filters['to_date'] = Carbon::parse($validated['to_date'])->addDay()->format('d-m-Y');

        $store->load(
            relations: ['user.sallaToken'],
        );

        dispatch(new PullOrdersJob(
            accessToken: $store->user->sallaToken->access_token,
            storeId: $store->id,
            filters: $filters,
        ));

        $this->dispatch('pull-orders-started', __('support.orders.messages.pull_started'));
    }

    protected function rules()
    {
        return [
            'store_id' => ['required', 'exists:stores,id'],
            'from_date' => ['required', 'date', 'before_or_equal:today'],
            'to_date' => ['required', 'date', 'before_or_equal:today', 'after_or_equal:from_date'],
        ];
    }

    protected function validationAttributes()
    {
        return [
            'store_id' => __('support.orders.pull_form.store'),
            'from_date' => __('support.orders.pull_form.from_date'),
            'to_date' => __('support.orders.pull_form.to_date'),
        ];
    }

    protected function messages()
    {
        return [
            'from_date.before_or_equal' => __('support.orders.pull_form.errors.from_date_should_be_before_now'),
            'to_date.before_or_equal' => __('support.orders.pull_form.errors.to_date_should_be_before_now'),
            'to_date.after_or_equal' => __('support.orders.pull_form.errors.to_date_should_be_after_from_date'),
        ];
    }
}
