@extends('client.layouts.master')

@section('title', __('products.title'))

@section('content')
    <div class="card">
        <div class="card-body">
            <table id="results-table" class="table table-hover table-row-bordered gy-5 gs-7"
                data-url="{{ route('client.products.index')}}"
            >
                <thead>
                    <tr class="fw-semibold fs-6 text-gray-800">
                        <th>{{ __('products.attributes.id') }}</th>
                        <th>{{ __('products.attributes.salla_id') }}</th>
                        <th>{{ __('products.attributes.image') }}</th>
                        <th>{{ __('products.attributes.name') }}</th>
                        <th>{{ __('products.attributes.sku') }}</th>
                        <th>{{ __('products.attributes.quantity') }}</th>
                        <th>{{ __('products.attributes.price') }}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('modals')
    @include('admin.pages.products.partials.index.modals.show')
@endpush

@push('afterScripts')
    @include('admin.pages.products.partials.index.after-scripts')
@endpush
