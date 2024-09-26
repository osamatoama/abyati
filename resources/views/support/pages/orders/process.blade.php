@extends('support.layouts.master')

@section('title', __('support.orders.title') . ' - ' . __('support.orders.process_order_#', ['id' => $order->reference_id]))

@section('actions')
    @include('support.pages.orders.partials.process.actions')
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
            <livewire:support.orders.process-order
                :order="$order"
            />
        </div>
        <div class="tab-pane fade" id="customer-tab" role="tabpanel">
            @include('support.pages.orders.partials.process.customer')
        </div>
    </div>
@endsection

@push('modals')

@endpush

@push('afterScripts')
    @include('support.pages.orders.partials.process.after-scripts')
@endpush
