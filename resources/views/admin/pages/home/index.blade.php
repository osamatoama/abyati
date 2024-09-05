@extends('client.layouts.master')

@section('title')
    {{ __('home.title') }}
@endsection

@section('content')

    <x-client.home.pull-process-alert />

    <x-client.order.setup-pull-orders-form />

    <div class="row gy-5 g-xl-10 mb-5">
        <a href="{{ route('client.orders.index') }}" class="col-sm-6 col-xl-3 mb-xl-10">
            <div class="card h-lg-100">
                <div class="card-body d-flex justify-content-between align-items-start flex-column">
                    <div class="m-0 d-flex flex-center w-60px h-60px rounded-3 bg-light-info bg-opacity-90">
                        <i class="fas fa-cart-shopping"></i>
                    </div>
                    <div class="d-flex flex-column my-7">
                        <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2 mb-3">
                            {{ $statistics['orders_count'] }}
                        </span>
                        <div class="m-0">
                            <span class="fw-semibold fs-6 text-gray-400">
                                {{ __('returns-system.orders.title') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </a>

        <a href="{{ route('client.return.requests.index') }}" class="col-sm-6 col-xl-3 mb-xl-10">
            <div class="card h-lg-100">
                <div class="card-body d-flex justify-content-between align-items-start flex-column">
                    <div class="m-0 d-flex flex-center w-60px h-60px rounded-3 bg-light-info bg-opacity-90">
                        <i class="fas fa-undo"></i>
                    </div>
                    <div class="d-flex flex-column my-7">
                        <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2 mb-3">
                            {{ $statistics['return_requests_count'] }}
                        </span>
                        <div class="m-0">
                            <span class="fw-semibold fs-6 text-gray-400">
                                {{ __('return.requests.index.title') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </a>

        <a href="{{ route('client.exchange.requests.index') }}" class="col-sm-6 col-xl-3 mb-xl-10">
            <div class="card h-lg-100">
                <div class="card-body d-flex justify-content-between align-items-start flex-column">
                    <div class="m-0 d-flex flex-center w-60px h-60px rounded-3 bg-light-info bg-opacity-90">
                        <i class="fas fa-rotate"></i>
                    </div>
                    <div class="d-flex flex-column my-7">
                        <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2 mb-3">
                            {{ $statistics['exchange_requests_count'] }}
                        </span>
                        <div class="m-0">
                            <span class="fw-semibold fs-6 text-gray-400">
                                {{ __('exchange.requests.index.title') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
@endsection

@push('afterScripts')
    @include('admin.pages.home.partials.after-scripts')
@endpush
