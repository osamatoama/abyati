@extends('employee.layouts.master')

@section('title', __('employee.shelves.title') . ' - ' . __('employee.shelves.num_#', ['name' => $shelf->name]))

@section('actions')
    @include('employee.pages.shelves.partials.show.actions')
@endsection

@section('content')

    <div class="card mb-5">
        <div class="card-header collapsible cursor-pointer rotate" data-bs-toggle="collapse" data-bs-target="#attach-product-card">
            <h3 class="card-title">{{ __('employee.shelves.actions.attach_product') }}</h3>
            <div class="card-toolbar rotate-180">
                <i class="ki-duotone ki-down fs-1"></i>
            </div>
        </div>

        <div id="attach-product-card" class="card-body collapse show">
            <livewire:employee.shelves.scan-products :$shelf />
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="shelf-products-table" class="table table-hover table-row-bordered gy-5 gs-7"
                    data-url="{{ route('employee.shelves.products', ['shelf' => $shelf->id]) }}"
                >
                    <thead>
                        <tr class="fw-semibold fs-6 text-gray-800">
                            <th style="width: 40px;">
                                <div class="form-check form-check-custom form-check-solid">
                                    <input id="checkbox-all-rows" class="form-check-input" type="checkbox" />
                                    <label class="form-check-label" for="checkbox-all-rows"></label>
                                </div>
                            </th>
                            <th>{{ __('employee.products.attributes.id') }}</th>
                            <th>{{ __('employee.products.attributes.salla_id') }}</th>
                            <th>{{ __('employee.products.attributes.image') }}</th>
                            <th>{{ __('employee.products.attributes.name') }}</th>
                            <th>{{ __('employee.products.attributes.sku') }}</th>
                            <th>{{ __('employee.products.attributes.remote_quantity') }}</th>
                            <th>{{ __('employee.products.attributes.attached_at') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    @include('employee.pages.shelves.partials.show.notifications')
@endsection

@push('modals')
    @include('employee.pages.shelves.partials.show.modals.attach-product')

    @include('employee.pages.shelves.partials.show.modals.bulk-transfer-products')
@endpush

@push('afterScripts')
    @include('employee.pages.shelves.partials.show.after-scripts')
@endpush
