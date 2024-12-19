@extends('employee.layouts.master')

@section('title', __('employee.stocktakings.title') . ($shelf ? ' - ' . __('employee.shelves.num_#', ['name' => $shelf->name]) : ''))

@section('actions')
    @include('employee.pages.stocktakings.partials.index.actions')
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="results-table" class="table table-hover table-row-bordered gy-5 gs-7"
                    data-url="{{ route('employee.stocktakings.index', query()) }}"
                >
                    <thead>
                        <tr class="fw-semibold fs-6 text-gray-800">
                            <th>{{ __('employee.stocktakings.attributes.id') }}</th>
                            @if(! $shelf)
                            <th>{{ __('employee.stocktakings.attributes.shelf') }}</th>
                            @endif
                            <th>{{ __('employee.stocktakings.attributes.employee') }}</th>
                            <th>{{ __('employee.stocktakings.attributes.status') }}</th>
                            <th>{{ __('employee.stocktakings.attributes.started_at') }}</th>
                            <th>{{ __('employee.stocktakings.attributes.finished_at') }}</th>
                            <th>{{ __('employee.stocktakings.attributes.issues_count') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('afterScripts')
    @include('employee.pages.stocktakings.partials.index.after-scripts')
@endpush
