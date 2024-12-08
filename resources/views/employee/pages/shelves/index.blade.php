@extends('employee.layouts.master')

@section('title', __('employee.shelves.title'))

@section('actions')
    @include('employee.pages.shelves.partials.index.actions')
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="results-table" class="table table-hover table-row-bordered gy-5 gs-7"
                    data-url="{{ route('employee.shelves.index', query()) }}"
                >
                    <thead>
                        <tr class="fw-semibold fs-6 text-gray-800">
                            <th>{{ __('employee.shelves.attributes.id') }}</th>
                            <th>{{ __('employee.shelves.attributes.warehouse') }}</th>
                            <th>{{ __('employee.shelves.attributes.name') }}</th>
                            <th>{{ __('employee.shelves.attributes.description') }}</th>
                            {{-- <th>{{ __('employee.shelves.attributes.order') }}</th> --}}
                            <th>{{ __('employee.shelves.attributes.products_count') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('afterScripts')
    @include('employee.pages.shelves.partials.index.after-scripts')
@endpush
