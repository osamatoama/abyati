@extends('employee.layouts.master')

@section('title', __('employee.reports.out_of_stock_products.title'))

@section('actions')
    @include('employee.pages.reports.out-of-stock-products.partials.actions')
@endsection

@section('content')
    <div class="card mb-5">
        <div class="card-body">
            <livewire:employee.reports.out-of-stock-products.filter-out-of-stock-products-report />
        </div>
    </div>

    <div id="results-card" class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="results-table" class="table table-row-bordered gy-5 gs-7" data-url="{{ route('employee.reports.out-of-stock-products.index') }}">
                    <thead>
                        <tr class="fw-semibold fs-6 text-gray-800">
                            <th>#</th>
                            <th>{{ __('employee.reports.out_of_stock_products.attributes.product_remote_id') }}</th>
                            <th>{{ __('employee.reports.out_of_stock_products.attributes.product_image') }}</th>
                            <th>{{ __('employee.reports.out_of_stock_products.attributes.product_name') }}</th>
                            <th>{{ __('employee.reports.out_of_stock_products.attributes.product_sku') }}</th>
                            <th>{{ __('employee.reports.out_of_stock_products.attributes.shelves') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('afterScripts')
    @include('employee.pages.reports.out-of-stock-products.partials.after-scripts')
@endpush
