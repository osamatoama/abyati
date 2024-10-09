@extends('employee.layouts.master')

@section('title', __('employee.orders.title') . ' - ' . __('employee.orders.process_order_#', ['id' => $order->reference_id]))

@section('actions')
    @include('employee.pages.orders.partials.process.actions')
@endsection

@section('content')
    <div class="card rounded border py-5 px-10 mb-3">
        <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
            <li class="nav-item">
                <a class="nav-link fw-semibold active" data-bs-toggle="tab" href="#products-tab">المنتجات</a>
            </li>
            <li class="nav-item">
                <a class="nav-link fw-semibold" data-bs-toggle="tab" href="#customer-tab">بيانات العميل</a>
            </li>
        </ul>
    </div>

    <div class="tab-content" id="process-order-tabs">
        <div class="tab-pane fade show active" id="products-tab" role="tabpanel">
            <livewire:employee.orders.process-order
                :order="$order"
            />
        </div>
        <div class="tab-pane fade" id="customer-tab" role="tabpanel">
            @include('employee.pages.orders.partials.process.customer')
        </div>
    </div>

    @include('employee.pages.orders.partials.process.notifications')
@endsection

@push('modals')
    <livewire:employee.orders.scan :$order />
@endpush

@push('afterScripts')
    @include('employee.pages.orders.partials.process.after-scripts')
@endpush
