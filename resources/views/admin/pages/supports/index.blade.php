@extends('admin.layouts.master')

@section('title', __('admin.supports.title'))

@section('actions')
    @include('admin.pages.supports.partials.index.actions')
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <table id="results-table" class="table table-hover table-row-bordered gy-5 gs-7">
                <thead>
                    <tr class="fw-semibold fs-6 text-gray-800">
                        <th>#</th>
                        <th>{{ __('admin.supports.attributes.name') }}</th>
                        <th>{{ __('admin.supports.attributes.branch') }}</th>
                        <th>{{ __('admin.supports.attributes.email') }}</th>
                        <th>{{ __('admin.supports.attributes.phone') }}</th>
                        <th>{{ __('admin.supports.attributes.active') }}</th>
                        <th></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('modals')
    @include('admin.pages.supports.partials.index.modals.create')
    @include('admin.pages.supports.partials.index.modals.edit')
@endpush

@push('afterScripts')
    @include('admin.pages.supports.partials.index.after-scripts')
@endpush
