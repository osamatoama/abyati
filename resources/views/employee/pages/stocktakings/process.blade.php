@extends('employee.layouts.master')

@section('title', __('employee.stocktakings.process_stocktaking_#', ['id' => $stocktaking->id]))

@section('actions')
    @include('employee.pages.stocktakings.partials.process.actions')
@endsection

@push('afterStyles')
    <link rel="stylesheet" href="{{ asset('assets/client/css/custom/employees/stocktakings/process.css') }}?version=1.0.21">
@endpush

@section('content')

    <livewire:employee.stocktakings.scan :$stocktaking />

    <livewire:employee.stocktakings.process-stocktaking
        :stocktaking="$stocktaking"
    />

    @include('employee.pages.stocktakings.partials.process.notifications')

@endsection

@push('afterScripts')
    @include('employee.pages.stocktakings.partials.process.after-scripts')
@endpush
