@extends('employee.layouts.master')

@section('title',
    __('employee.shelves.title')
    . ' - ' . __('employee.shelves.num_#', ['name' => $shelf->name])
    . ' (' . __('employee.shelves.actions.sync_products') . ')'
)

@section('actions')
    @include('employee.pages.shelves.partials.sync.actions')
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="shelf-sync-products-table" class="table table-hover table-row-bordered gy-5 gs-7"
                    data-url="{{ route('employee.shelves.products.sync', ['shelf' => $shelf->id]) }}"
                >
                    <thead>
                        <tr class="fw-semibold fs-6 text-gray-800">
                            <th>{{ __('employee.products.attributes.id') }}</th>
                            <th>{{ __('employee.products.attributes.salla_id') }}</th>
                            <th>{{ __('employee.products.attributes.synced') }}</th>
                            <th>{{ __('employee.products.attributes.image') }}</th>
                            <th>{{ __('employee.products.attributes.name') }}</th>
                            <th>{{ __('employee.products.attributes.sku') }}</th>
                            <th>{{ __('employee.products.attributes.remote_quantity') }}</th>
                            <th>{{ __('employee.products.attributes.attached_at') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('afterScripts')
    @include('employee.pages.shelves.partials.sync.after-scripts')
@endpush
