@extends('admin.layouts.master')

@section('title', __('admin.orders.title'))

@section('actions')
    @include('admin.pages.orders.partials.index.actions')
@endsection

@section('content')
    <livewire:admin.orders.order-tabs />

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table
                    id="results-table" class="table table-hover table-row-bordered gy-5 gs-7"
                    data-url="{{ route('admin.orders.index', query()) }}"
                >
                    <thead>
                        <tr class="fw-semibold fs-6 text-gray-800">
                            <th>{{ __('admin.orders.attributes.order_number') }}</th>
                            <th>{{ __('admin.orders.attributes.store') }}</th>
                            <th>{{ __('admin.orders.attributes.branch') }}</th>
                            {{-- <th>{{ __('admin.orders.attributes.customer') }}</th> --}}
                            <th>{{ __('admin.orders.attributes.date') }}</th>
                            <th>{{ __('admin.orders.attributes.status') }}</th>
                            <th>{{ __('admin.orders.attributes.completion_status') }}</th>
                            <th>{{ __('admin.orders.attributes.employee') }}</th>
                            <th>{{ __('admin.orders.attributes.items_count') }}</th>
                            <th>{{ __('admin.orders.attributes.total') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('modals')
    @include('admin.pages.orders.partials.index.modals.show')

    @include('admin.pages.orders.partials.index.modals.history')

    <livewire:admin.orders.pull-orders-form />
@endpush

@push('afterScripts')
    @include('admin.pages.orders.partials.index.after-scripts')
@endpush
