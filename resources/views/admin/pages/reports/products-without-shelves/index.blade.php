@extends('admin.layouts.master')

@section('title', __('admin.reports.products_without_shelves.title'))

@section('actions')
    @include('admin.pages.reports.products-without-shelves.partials.actions')
@endsection

@section('content')
    <div class="card mb-5">
        <div class="card-body">
            <livewire:admin.reports.products-without-shelves.filter-products-without-shelves-report />
        </div>
    </div>

    <div id="results-card" class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="results-table" class="table table-row-bordered gy-5 gs-7" data-url="{{ route('admin.reports.products-without-shelves.index') }}">
                    <thead>
                        <tr class="fw-semibold fs-6 text-gray-800">
                            <th>#</th>
                            <th>{{ __('admin.reports.products_without_shelves.attributes.product_remote_id') }}</th>
                            <th>{{ __('admin.reports.products_without_shelves.attributes.product_image') }}</th>
                            <th>{{ __('admin.reports.products_without_shelves.attributes.product_name') }}</th>
                            <th>{{ __('admin.reports.products_without_shelves.attributes.product_sku') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('afterScripts')
    @include('admin.pages.reports.products-without-shelves.partials.after-scripts')
@endpush
