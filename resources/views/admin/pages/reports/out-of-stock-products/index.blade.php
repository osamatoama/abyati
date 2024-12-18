@extends('admin.layouts.master')

@section('title', __('admin.reports.out_of_stock_products.title'))

@section('actions')
    @include('admin.pages.reports.out-of-stock-products.partials.actions')
@endsection

@section('content')
    <div class="card mb-5">
        <div class="card-body">
            <livewire:admin.reports.out-of-stock-products.filter-out-of-stock-products-report />
        </div>
    </div>

    <div id="results-card" class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="results-table" class="table table-row-bordered gy-5 gs-7" data-url="{{ route('admin.reports.out-of-stock-products.index') }}">
                    <thead>
                        <tr class="fw-semibold fs-6 text-gray-800">
                            <th>#</th>
                            <th>{{ __('admin.reports.out_of_stock_products.attributes.product_remote_id') }}</th>
                            <th>{{ __('admin.reports.out_of_stock_products.attributes.product_image') }}</th>
                            <th>{{ __('admin.reports.out_of_stock_products.attributes.product_name') }}</th>
                            <th>{{ __('admin.reports.out_of_stock_products.attributes.product_sku') }}</th>
                            <th>{{ __('admin.reports.out_of_stock_products.attributes.shelves') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('afterScripts')
    @include('admin.pages.reports.out-of-stock-products.partials.after-scripts')
@endpush
