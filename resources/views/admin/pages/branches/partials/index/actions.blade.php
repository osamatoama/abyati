@if(can('branches.add'))
    <div class="d-flex align-items-center position-relative my-1">
        <a href="{{ route('admin.branches.create') }}" class="btn btn-success">
            <i class="fas fa-plus-circle"></i> {{ __('globals.add') }}
        </a>
    </div>
@endif
