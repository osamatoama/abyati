@extends('admin.layouts.master')

@section('title', __('admin.shelves.title'))

@section('actions')
    @include('admin.pages.shelves.partials.index.actions')
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="results-table" class="table table-hover table-row-bordered gy-5 gs-7"
                    data-url="{{ route('admin.shelves.index', query()) }}"
                >
                    <thead>
                        <tr class="fw-semibold fs-6 text-gray-800">
                            <th>{{ __('admin.shelves.attributes.id') }}</th>
                            <th>{{ __('admin.shelves.attributes.warehouse') }}</th>
                            <th>{{ __('admin.shelves.attributes.name') }}</th>
                            {{-- <th>{{ __('admin.shelves.attributes.order') }}</th> --}}
                            <th>{{ __('admin.shelves.attributes.products_count') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('afterScripts')
    @include('admin.pages.shelves.partials.index.after-scripts')
@endpush
