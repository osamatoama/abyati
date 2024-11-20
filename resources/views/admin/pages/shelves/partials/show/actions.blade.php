@if(can('shelves.edit'))
    <div class="d-flex align-items-center position-relative">
        <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#attach-product-modal">
            <i class="fas fa-plus"></i> {{ __('admin.shelves.actions.attach_product') }}
        </a>
    </div>
@endif

<div class="d-flex align-items-center position-relative">
    <a href="{{ route('admin.shelves.index') }}" class="btn btn-light">
        <i class="fas fa-arrow-left pe-0"></i> {{ __('globals.back') }}
    </a>
</div>
