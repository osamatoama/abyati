@extends('admin.layouts.master')

@section('title', __('admin.employees.title'))

@section('actions')
    @include('admin.pages.employees.partials.index.actions')
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <table id="results-table" class="table table-striped table-row-bordered gy-5 gs-7">
                <thead>
                    <tr class="fw-semibold fs-6 text-gray-800">
                        <th>#</th>
                        <th>{{ __('admin.employees.attributes.name') }}</th>
                        <th>{{ __('admin.employees.attributes.branch') }}</th>
                        <th>{{ __('admin.employees.attributes.email') }}</th>
                        <th>{{ __('admin.employees.attributes.phone') }}</th>
                        <th>{{ __('admin.employees.attributes.active') }}</th>
                        <th></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('modals')
    @include('admin.pages.employees.partials.index.modals.create')
    @include('admin.pages.employees.partials.index.modals.edit')
@endpush

@push('afterScripts')
    @include('admin.pages.employees.partials.index.after-scripts')
@endpush
