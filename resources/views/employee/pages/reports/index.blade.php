@extends('employee.layouts.master')

@section('title', __('employee.reports.title'))

@section('content')
        @if(auth('employee')->user()->hasRole(\App\Enums\EmployeeRole::STOCKTAKING))
            <div class="col-md-3">
                <a href="{{ route('employee.reports.out-of-stock-products.index') }}" class="card hover-elevate-up shadow-sm parent-hover mb-5">
                    <div class="card-body d-flex align-items-center">
                        <span class="svg-icon svg-icon-muted svg-icon-2hx">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor"/>
                                <rect x="6.01041" y="10.9247" width="12" height="2" rx="1" fill="currentColor"/>
                            </svg>
                        </span>

                        <span class="ms-3 text-gray-700 parent-hover-primary fs-6 fw-bold">
                            {{ __('employee.reports.out_of_stock_products.title') }}
                        </span>
                    </div>
                </a>
            </div>
        @endif
    </div>
@endsection
