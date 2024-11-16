@extends('admin.layouts.master')

@section('title', __('admin.shelves.title') . ' - ' . __('admin.shelves.num_#', ['name' => $shelf->name]))

@section('actions')
    @include('admin.pages.shelves.partials.show.actions')
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="shelf-products-table" class="table table-hover table-row-bordered gy-5 gs-7"
                    data-url="{{ route('admin.shelves.products', ['shelf' => $shelf->id]) }}"
                >
                    <thead>
                        <tr class="fw-semibold fs-6 text-gray-800">
                            <th>{{ __('admin.products.attributes.id') }}</th>
                            <th>{{ __('admin.products.attributes.salla_id') }}</th>
                            <th>{{ __('admin.products.attributes.image') }}</th>
                            <th>{{ __('admin.products.attributes.name') }}</th>
                            <th>{{ __('admin.products.attributes.store') }}</th>
                            <th>{{ __('admin.products.attributes.sku') }}</th>
                            {{-- <th></th> --}}
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('afterScripts')
    @include('admin.pages.shelves.partials.show.after-scripts')
@endpush
