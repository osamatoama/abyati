@extends('admin.layouts.master')

@section('title', __('admin.shelves.title') . ' - ' . __('admin.shelves.num_#', ['name' => $shelf->name]))

@section('actions')
    @include('admin.pages.shelves.partials.show.actions')
@endsection

@section('content')

    <div class="card mb-5">
        <div class="card-header collapsible cursor-pointer rotate" data-bs-toggle="collapse" data-bs-target="#attach-product-card">
            <h3 class="card-title">{{ __('admin.shelves.actions.attach_product') }}</h3>
            <div class="card-toolbar rotate-180">
                <i class="ki-duotone ki-down fs-1"></i>
            </div>
        </div>

        <div id="attach-product-card" class="card-body collapse show">
            <livewire:admin.shelves.scan-products :$shelf />
        </div>
    </div>

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
                            <th>{{ __('admin.products.attributes.sku') }}</th>
                            <th>{{ __('admin.products.attributes.attached_at') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    @include('admin.pages.shelves.partials.show.notifications')
@endsection

@push('modals')
    @include('admin.pages.shelves.partials.show.modals.attach-product')
@endpush

@push('afterScripts')
    @include('admin.pages.shelves.partials.show.after-scripts')
@endpush
