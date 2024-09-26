@extends('employee.layouts.master')

@section('title', __('employee.orders.title'))

@section('actions')
    @include('employee.pages.orders.partials.index.actions')
@endsection

@push('afterStyles')
    <link rel="stylesheet" href="{{ assetCustom('assets/client/css/custom/orders.css') }}?version=1.0.3">
@endpush

@section('content')
    <livewire:employee.orders.order-tabs />

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table
                    id="results-table" class="table table-hover table-row-bordered gy-5 gs-7"
                    data-url="{{ route('employee.orders.index', query()) }}"
                >
                    <thead>
                        <tr class="fw-semibold fs-6 text-gray-800">
                            <th>{{ __('employee.orders.attributes.order_number') }}</th>
                            <th>{{ __('employee.orders.attributes.store') }}</th>
                            <th>{{ __('employee.orders.attributes.customer') }}</th>
                            <th>{{ __('employee.orders.attributes.date') }}</th>
                            <th>{{ __('employee.orders.attributes.status') }}</th>
                            <th>{{ __('employee.orders.attributes.completion_status') }}</th>
                            <th>{{ __('employee.orders.attributes.employee') }}</th>
                            <th>{{ __('employee.orders.attributes.items_count') }}</th>
                            <th>{{ __('employee.orders.attributes.total') }}</th>
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
