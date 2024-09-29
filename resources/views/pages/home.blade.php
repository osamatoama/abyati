@extends('admin.layouts.error')

@section('title', 'intro')

@push('afterStyles')
<style>
    body {
        background-image: url("{{ assetCustom('assets/client/media/auth/bg1.jpg') }}");
    }
    [data-bs-theme="dark"] body {
        background-image: url("{{ assetCustom('assets/client/media/auth/bg1-dark.jpg') }}");
    }
</style>
@endpush

@section('content')
    <div class="d-flex flex-column flex-center flex-column-fluid">
        <div class="d-flex flex-column flex-center text-center p-10">
            <div class="card card-flush w-lg-650px py-5">
                <div class="card-body py-15 py-lg-20">
                    <h1 class="fw-bolder fs-2hx text-gray-900 mb-4">
                        {{ siteTitle() }}
                    </h1>
                    <div class="mb-3">
                        <img src="{{ asset('assets/client/media/logos/logo.png') }}" class="mw-100 mh-300px" alt="" />
                    </div>
                    <div class="mb-0">
                        <a href="{{ route('employee.login') }}" class="btn btn-sm btn-primary">
                            <i class="fa-solid fa-users"></i> {{ __('admin.employees.title') }}
                        </a>
                        <a href="{{ route('support.login') }}" class="btn btn-sm btn-primary">
                            <i class="fa-solid fa-headset"></i> {{ __('admin.supports.title') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
