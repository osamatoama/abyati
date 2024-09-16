@extends('employee.layouts.master')

@section('title', __('employee.orders.title') . ' - ' . __('employee.orders.process_order_#', ['id' => $order->reference_id]))

@section('actions')
    @include('employee.pages.orders.partials.process.actions')
@endsection

@section('content')
    <livewire:employee.orders.process-order
        :order="$order"
    />
@endsection

@push('modals')

@endpush

@push('afterScripts')
    @include('employee.pages.orders.partials.process.after-scripts')
@endpush
