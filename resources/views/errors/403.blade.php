@extends('admin.layouts.error')

@section('title', 403)

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
                        {{ __("globals.errors.forbidden") }}
                    </h1>
                    {{-- <div class="mb-3">
                        <img src="{{ assetCustom('assets/client/media/auth/401-error.png') }}" class="mw-100 mh-300px theme-light-show" alt="" />
                        <img src="{{ assetCustom('assets/client/media/auth/401-error-dark.png') }}" class="mw-100 mh-300px theme-dark-show" alt="" />
                    </div> --}}
                    <div class="mb-0">
                        <a href="{{ route('admin.home') }}" class="btn btn-sm btn-primary">
                            {{ __("globals.returnToHome") }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
