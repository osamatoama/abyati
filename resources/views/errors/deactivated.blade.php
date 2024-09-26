@extends('admin.layouts.error')

@section('title', __("globals.errors.accountDeactivated.title"))

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
                        {{ __("globals.errors.accountDeactivated.title") }}
                    </h1>
                    <div class="fw-semibold fs-6 text-gray-500 mb-7">
                        {{ __("globals.errors.accountDeactivated.description") }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
