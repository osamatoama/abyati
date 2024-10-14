@extends('employee.layouts.master')

@section('title', __('employee.orders.title'))

@section('actions')
    @include('employee.pages.orders.partials.index.actions')
@endsection

@push('afterStyles')
    <link rel="stylesheet" href="{{ asset('assets/client/css/custom/employees/orders/index.css') }}?version=1.0.21">
@endpush

@section('content')
    <livewire:employee.orders.order-tabs />

    <div class="orders-table-card card">
        <div class="card-body">
            <div class="table-responsive">
                <table
                    id="results-table" class="table table-hover table-row-bordered gy-5 gs-7"
                    data-url="{{ route('employee.orders.index', query()) }}"
                >
                    <thead>
                        <tr class="fw-semibold fs-6 text-gray-800">
                            <th data-label="{{ __('employee.orders.attributes.order_number') }}">{{ __('employee.orders.attributes.order_number') }}</th>
                            <th data-label="{{ __('employee.orders.attributes.store') }}">{{ __('employee.orders.attributes.store') }}</th>
                            <th data-label="{{ __('employee.orders.attributes.customer') }}">{{ __('employee.orders.attributes.customer') }}</th>
                            <th data-label="{{ __('employee.orders.attributes.date') }}">{{ __('employee.orders.attributes.date') }}</th>
                            <th data-label="{{ __('employee.orders.attributes.status') }}">{{ __('employee.orders.attributes.status') }}</th>
                            <th data-label="{{ __('employee.orders.attributes.completion_status') }}">{{ __('employee.orders.attributes.completion_status') }}</th>
                            <th data-label="{{ __('employee.orders.attributes.employee') }}">{{ __('employee.orders.attributes.employee') }}</th>
                            <th data-label="{{ __('employee.orders.attributes.items_count') }}">{{ __('employee.orders.attributes.items_count') }}</th>
                            <th data-label="{{ __('employee.orders.attributes.total') }}">{{ __('employee.orders.attributes.total') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('modals')
    @include('employee.pages.orders.partials.index.modals.show')

    @include('employee.pages.orders.partials.index.modals.history')

    <livewire:employee.orders.pull-orders-form />
@endpush

@push('afterScripts')
    @include('employee.pages.orders.partials.index.after-scripts')
@endpush
