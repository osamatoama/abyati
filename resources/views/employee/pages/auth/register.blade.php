@extends('employee.layouts.auth')

@section('title', 'Register')

@section('content')
    <form class="form w-100" action="{{ route('employee.register') }}" method="POST">
        @csrf
        <div class="text-center mb-11">
            <h1 class="text-dark fw-bolder mb-3">
                Sign Up
            </h1>
            <div class="text-gray-500 fw-semibold fs-6">
                Your Social Campaigns
            </div>
        </div>
        @include('employee.auth.partials.social')
        {{--<div class="separator separator-content my-14">
            <span class="w-125px text-gray-500 fw-semibold fs-7">
                Or with email
            </span>
        </div>
        <div class="fv-row mb-8">
            <input type="text" placeholder="Name" name="name" autocomplete="off" @class(['form-control bg-transparent', 'is-invalid' => $errors->has('name')]) value="{{ old('name') }}" required>
            @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="fv-row mb-8">
            <input type="text" placeholder="Email" name="email" autocomplete="off" @class(['form-control bg-transparent', 'is-invalid' => $errors->has('email')]) value="{{ old('email') }}" required>
            @error('email')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="fv-row mb-8">
            <input type="text" placeholder="Phone" name="phone" autocomplete="off" @class(['form-control bg-transparent', 'is-invalid' => $errors->has('phone')]) value="{{ old('phone') }}" required>
            @error('phone')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="fv-row mb-8" data-kt-password-meter="true">
            <div class="mb-1">
                <div class="position-relative mb-3">
                    <input @class(['form-control bg-transparent', 'is-invalid' => $errors->has('password')]) type="password" placeholder="Password" name="password" autocomplete="off" required>
                    @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                    <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                        <i class="ki-duotone ki-eye-slash fs-2"></i>
                        <i class="ki-duotone ki-eye fs-2 d-none"></i>
                    </span>
                </div>
                <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                </div>
            </div>
            <div class="text-muted">Use 8 or more characters with a mix of letters, numbers & symbols.</div>
        </div>
        <div class="fv-row mb-8">
            <input placeholder="Repeat Password" name="password_confirmation" type="password" autocomplete="off" class="form-control bg-transparent" required>
        </div>
        <div class="fv-row mb-8">
            <label @class(['form-check form-check-inline', 'is-invalid' => $errors->has('terms')])>
                <input class="form-check-input" type="checkbox" name="terms" value="1" @checked(old('terms')) required>
                <span class="form-check-label fw-semibold text-gray-700 fs-base ms-1">
                    I Accept the
                    <a href="" class="ms-1 link-primary">
                        Terms
                    </a>
                </span>
            </label>
            @error('terms')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="d-grid mb-10">
            <button type="submit" class="btn btn-primary">
                Sign up
            </button>
        </div>--}}
        <div class="text-gray-500 text-center fw-semibold fs-6">
            Already have an Account?
            <a href="{{ route('employee.login') }}" class="link-primary fw-semibold">
                Sign in
            </a>
        </div>
    </form>
@endsection
