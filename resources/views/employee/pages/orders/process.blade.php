@extends('employee.layouts.master')

@section('title', __('employee.orders.process_order_#', ['id' => $order->reference_id]))

@section('actions')
    @include('employee.pages.orders.partials.process.actions')
@endsection

@push('afterStyles')
    <link rel="stylesheet" href="{{ asset('assets/client/css/custom/employees/orders/process.css') }}?version=1.0.21">
@endpush

@section('content')

    <livewire:employee.orders.scan :$order />

    <livewire:employee.orders.process-order
        :order="$order"
    />

    @include('employee.pages.orders.partials.process.customer')

    @include('employee.pages.orders.partials.process.notifications')
@endsection

@push('afterScripts')
    @include('employee.pages.orders.partials.process.after-scripts')
@endpush
