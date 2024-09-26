@extends('admin.layouts.master')

@section('title', __('admin.users.title'))

@section('actions')
    @include('admin.pages.users.partials.index.actions')
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <table id="results-table" class="table table-hover table-row-bordered gy-5 gs-7">
                <thead>
                    <tr class="fw-semibold fs-6 text-gray-800">
                        <th>#</th>
                        <th>{{ __('admin.users.attributes.name') }}</th>
                        <th>{{ __('admin.users.attributes.role') }}</th>
                        <th>{{ __('admin.users.attributes.email') }}</th>
                        <th>{{ __('admin.users.attributes.phone') }}</th>
                        <th>{{ __('admin.users.attributes.active') }}</th>
                        <th></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('modals')
    @include('admin.pages.users.partials.index.modals.create')
    @include('admin.pages.users.partials.index.modals.edit')
@endpush

@push('afterScripts')
    @include('admin.pages.users.partials.index.after-scripts')
@endpush
