@extends('support.layouts.master')

@section('title', __('support.orders.title'))

@section('actions')
    @include('support.pages.orders.partials.index.actions')
@endsection

@section('content')
    <livewire:support.orders.order-tabs />

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table
                    id="results-table" class="table table-hover table-row-bordered gy-5 gs-7"
                    data-url="{{ route('support.orders.index', query()) }}"
                >
                    <thead>
                        <tr class="fw-semibold fs-6 text-gray-800">
                            <th>{{ __('support.orders.attributes.order_number') }}</th>
                            <th>{{ __('support.orders.attributes.store') }}</th>
                            <th>{{ __('support.orders.attributes.customer') }}</th>
                            <th>{{ __('support.orders.attributes.date') }}</th>
                            <th>{{ __('support.orders.attributes.status') }}</th>
                            <th>{{ __('support.orders.attributes.completion_status') }}</th>
                            <th>{{ __('support.orders.attributes.employee') }}</th>
                            <th>{{ __('support.orders.attributes.items_count') }}</th>
                            <th>{{ __('support.orders.attributes.total') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('modals')
    @include('support.pages.orders.partials.index.modals.show')

    @include('support.pages.orders.partials.index.modals.history')

    <livewire:support.orders.pull-orders-form />
@endpush

@push('afterScripts')
    @include('support.pages.orders.partials.index.after-scripts')
@endpush
