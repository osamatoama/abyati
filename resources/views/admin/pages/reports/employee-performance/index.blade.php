@extends('admin.layouts.master')

@section('title', __('admin.reports.employee_performance.title'))

@section('actions')
    @include('admin.pages.reports.employee-performance.partials.actions')
@endsection

@section('content')
    <div class="card mb-5">
        <div class="card-body">
            <livewire:admin.reports.employee-performance.filter-employee-performance-report />
        </div>
    </div>

    <livewire:admin.reports.employee-performance.employee-performance-report-tabs />

    <div id="results-card" class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="results-table" class="table table-row-bordered gy-5 gs-7" data-url="{{ route('admin.reports.employee-performance.index') }}">
                    <thead>
                        <tr class="fw-semibold fs-6 text-gray-800">
                            <th>#</th>
                            <th>{{ __('admin.reports.employee_performance.attributes.order_number') }}</th>
                            <th>{{ __('admin.reports.employee_performance.attributes.started_at') }}</th>
                            <th>{{ __('admin.reports.employee_performance.attributes.completed_at') }}</th>
                            <th>{{ __('admin.reports.employee_performance.attributes.duration_minutes') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('afterScripts')
    @include('admin.pages.reports.employee-performance.partials.after-scripts')
@endpush
