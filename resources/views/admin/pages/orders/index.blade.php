@extends('admin.layouts.master')

@section('title', __('orders.title'))

@section('actions')
    @include('admin.pages.orders.partials.index.actions')
@endsection

@push('afterStyles')
    <link rel="stylesheet" href="{{ assetCustom('assets/client/css/custom/orders.css') }}?version=1.0.3">
@endpush

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="results-table" class="table table-hover table-row-bordered gy-5 gs-7">
                    <thead>
                        <tr class="fw-semibold fs-6 text-gray-800">
                            <th>{{ __('orders.attributes.order_number') }}</th>
                            <th>{{ __('orders.attributes.customer') }}</th>
                            <th>{{ __('orders.attributes.date') }}</th>
                            <th>{{ __('orders.attributes.status') }}</th>
                            <th>{{ __('orders.attributes.payment_method') }}</th>
                            <th>{{ __('orders.attributes.items_count') }}</th>
                            <th>{{ __('orders.attributes.total') }}</th>
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

    <livewire:order.pull-orders-form />
@endpush

@push('afterScripts')
    @include('admin.pages.orders.partials.index.after-scripts')
@endpush
