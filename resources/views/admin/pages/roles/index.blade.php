@extends('admin.layouts.master')

@section('title', __('admin.roles.title'))

@section('actions')
    @include('admin.pages.roles.partials.index.actions')
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="results-table" class="table table-hover table-row-bordered gy-5 gs-7">
                    <thead>
                        <tr class="fw-semibold fs-6 text-gray-800">
                            <th>{{ __('admin.roles.attributes.id') }}</th>
                            <th>{{ __('admin.roles.attributes.name') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('afterScripts')
    @include('admin.pages.roles.partials.index.after-scripts')
@endpush
