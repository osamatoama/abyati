@extends('admin.layouts.master')

@section('title', __('admin.branches.title') . ' - ' . $branch->name)

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('admin.branches.actions.edit_branch') }}</h3>
        </div>

        <div class="card-body">
            <livewire:admin.branches.update-branch-form
                :branch="$branch"
            />
        </div>
    </div>
@endsection

@push('afterScripts')
    @include('admin.pages.branches.partials.show.after-scripts')
@endpush
