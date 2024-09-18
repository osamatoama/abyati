@extends('admin.layouts.master')

@section('title', __("roles.action.edit"))

@section('content')
    <div class="card">
        <form action="{{ route("admin.roles.update", $role) }}" method="post">
            @csrf
            @method("patch")
            <div class="card-body">
                <div class="form-group mt-3 row">
                    <label for="name" class="col-md-2 form-control-lg">{{ __('admin.roles.attributes.name') }}</label>
                    <div class="col-md-10">
                        <input type="text" name="name" value="{{ old('name', $role['name']) }}"
                               id="name"
                               placeholder="{{ __('admin.roles.attributes.name') }}"
                               required
                               class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div><!--col-->
                </div>

                <div class="form-group mt-3 row">
                    <label for="permissions"
                           class="col-md-2 form-control-lg">{{ __('admin.roles.attributes.permissions') }}</label>
                    <div class="col-md-10">
                        <livewire:admin.permissions.select-permissions :role="$role"/>

                        @error('permissions')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div><!--col-->
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route("admin.roles.index") }}"
                   class="btn btn-light">{{ __("globals.close") }}</a>
                <button type="submit" class="btn btn-primary">{{ __("globals.save") }}</button>
            </div>

        </form>
    </div>

@endsection
