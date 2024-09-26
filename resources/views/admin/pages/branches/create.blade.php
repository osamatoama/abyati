@extends('admin.layouts.master')

@section('title', __('admin.branches.actions.create'))

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('admin.branches.actions.create') }}</h3>
        </div>

        <div class="card-body">
            <livewire:admin.branches.create-branch-form />
        </div>
    </div>
@endsection

@push('afterScripts')
    @include('admin.pages.branches.partials.create.after-scripts')
@endpush
