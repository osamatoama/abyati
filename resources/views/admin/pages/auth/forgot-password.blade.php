@extends('admin.layouts.auth')

@section('title', 'Forgot password')

@section('content')
    <form class="form w-100" action="" method="POST">
        @csrf
        <div class="text-center mb-10">
            <h1 class="text-dark fw-bolder mb-3">
                Forgot Password ?
            </h1>
            <div class="text-gray-500 fw-semibold fs-6">
                Enter your email to reset your password.
            </div>
        </div>
        <div class="fv-row mb-8">
            <input type="text" placeholder="Email" name="email" autocomplete="off" class="form-control bg-transparent">
        </div>
        <div class="d-flex flex-wrap justify-content-center pb-lg-0">
            <button type="submit" class="btn btn-primary me-4">
                Submit
            </button>
            <a href="{{ route('admin.login') }}" class="btn btn-light">
                Cancel
            </a>
        </div>
    </form>
@endsection
