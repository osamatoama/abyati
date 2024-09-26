@extends('admin.layouts.master')

@section('title', __('admin.products.title'))

@section('actions')
    @include('admin.pages.products.partials.index.actions')
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="results-table" class="table table-hover table-row-bordered gy-5 gs-7"
                    data-url="{{ route('admin.products.index', query()) }}"
                >
                    <thead>
                        <tr class="fw-semibold fs-6 text-gray-800">
                            <th>{{ __('admin.products.attributes.id') }}</th>
                            <th>{{ __('admin.products.attributes.salla_id') }}</th>
                            <th>{{ __('admin.products.attributes.image') }}</th>
                            <th>{{ __('admin.products.attributes.name') }}</th>
                            <th>{{ __('admin.products.attributes.store') }}</th>
                            <th>{{ __('admin.products.attributes.sku') }}</th>
                            {{-- <th>{{ __('admin.products.attributes.quantity') }}</th>
                            <th>{{ __('admin.products.attributes.price') }}</th> --}}
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('modals')
    @include('admin.pages.products.partials.index.modals.show')
@endpush

@push('afterScripts')
    @include('admin.pages.products.partials.index.after-scripts')
@endpush
