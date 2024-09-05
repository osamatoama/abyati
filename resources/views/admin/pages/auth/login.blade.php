@extends('admin.layouts.auth')

@section('title', __('admin.auth.login'))

@push('styles')
    <link rel="stylesheet" href="{{ assetCustom('assets/client/css/custom/login.css') }}?version=1.0.0" />
@endpush

@section('content')
    <form id="login-form" class="form w-100" action="{{ route("admin.login") }}">
        @csrf

        <div class="text-center mb-11">
            <h1 class="text-dark fw-bolder mb-3">
                {{ __('admin.auth.login') }}
            </h1>
        </div>

        @include("admin.layouts.partials.messages")

        <div class="fv-row mb-8">
            <input id="email" type="email" placeholder="{{ __("admin.auth.email") }}" name="email" autocomplete="off"
                   class="form-control bg-transparent">

            <div id="login-form-email-error" class="form-input-error text-danger"></div>
        </div>

        <div class="fv-row mb-8">
            <input id="password" type="password" placeholder="{{ __("admin.auth.password") }}" name="password"
                   autocomplete="off"
                   class="form-control bg-transparent">

            <div id="login-form-password-error" class="form-input-error text-danger"></div>
        </div>

        <div class="fv-row mb-8">
            <div class="form-check form-check-custom form-check-lg">
                <input class="form-check-input" type="checkbox" value="1" id="remember" name="remember" />
                <label class="form-check-label fs-5" for="remember">
                    {{ __('admin.auth.remember_me') }}
                </label>
            </div>
        </div>

        {{--        <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">--}}
        {{--            <div></div>--}}
        {{--            <a href="#" class="link-primary">--}}
        {{--                Forgot Password ?--}}
        {{--            </a>--}}
        {{--        </div>--}}
        <div class="d-grid mb-10">
            <button type="submit" class="btn btn-primary">
                {{ __("admin.admin.auth.sign_in") }}
            </button>
        </div>
    </form>
@endsection

@push('scripts')
    @include('admin.pages.auth.partials.login.scripts')
@endpush
