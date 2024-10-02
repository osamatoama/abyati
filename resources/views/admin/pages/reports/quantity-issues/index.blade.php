@extends('admin.layouts.master')

@section('title', __('admin.reports.quantity_issues.title'))

@section('actions')
    @include('admin.pages.reports.quantity-issues.partials.actions')
@endsection

@section('content')
    {{-- <div class="card mb-5">
        <div class="card-body">
            <livewire:admin.reports.quantity-issues.filter-quantity-issues-report />
        </div>
    </div> --}}

    {{-- <livewire:admin.reports.quantity-issues.quantity-issues-report-tabs /> --}}

    <div id="results-card" class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="results-table" class="table table-row-bordered gy-5 gs-7" data-url="{{ route('admin.reports.quantity-issues.index') }}">
                    <thead>
                        <tr class="fw-semibold fs-6 text-gray-800">
                            <th>#</th>
                            <th>{{ __('admin.reports.quantity_issues.attributes.product_remote_id') }}</th>
                            <th>{{ __('admin.reports.quantity_issues.attributes.product_name') }}</th>
                            <th>{{ __('admin.reports.quantity_issues.attributes.issues_count') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('afterScripts')
    @include('admin.pages.reports.quantity-issues.partials.after-scripts')
@endpush
