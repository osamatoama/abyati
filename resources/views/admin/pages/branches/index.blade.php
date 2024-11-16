@extends('admin.layouts.master')

@section('title', __('admin.branches.title'))

@section('actions')
    @include('admin.pages.branches.partials.index.actions')
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="results-table" class="table table-hover table-row-bordered gy-5 gs-7"
                    data-url="{{ route('admin.branches.index')}}"
                >
                    <thead>
                        <tr class="fw-semibold fs-6 text-gray-800">
                            <th>{{ __('admin.branches.attributes.id') }}</th>
                            <th>{{ __('admin.branches.attributes.remote_id') }}</th>
                            <th>{{ __('admin.branches.attributes.name') }}</th>
                            <th>{{ __('admin.branches.attributes.warehouses_count') }}</th>
                            <th>{{ __('admin.branches.attributes.active') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('afterScripts')
    @include('admin.pages.branches.partials.index.after-scripts')
@endpush
