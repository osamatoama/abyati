@extends('support.layouts.master')

@section('title', __('support.reports.products_without_sku.title'))

@section('actions')
    @include('support.pages.reports.products-without-sku.partials.actions')
@endsection

@section('content')
    {{-- <div class="card mb-5">
        <div class="card-body">
            <livewire:support.reports.products-without-sku.filter-products-without-sku-report />
        </div>
    </div> --}}

    {{-- <livewire:support.reports.products-without-sku.products-without-sku-report-tabs /> --}}

    <div id="results-card" class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="results-table" class="table table-row-bordered gy-5 gs-7" data-url="{{ route('support.reports.products-without-sku.index') }}">
                    <thead>
                        <tr class="fw-semibold fs-6 text-gray-800">
                            <th>#</th>
                            <th>{{ __('support.reports.products_without_sku.attributes.salla_id') }}</th>
                            <th>{{ __('support.reports.products_without_sku.attributes.image') }}</th>
                            <th>{{ __('support.reports.products_without_sku.attributes.name') }}</th>
                            <th>{{ __('support.reports.products_without_sku.attributes.store') }}</th>
                            <th>{{ __('support.reports.products_without_sku.attributes.sku') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('afterScripts')
    @include('support.pages.reports.products-without-sku.partials.after-scripts')
@endpush
