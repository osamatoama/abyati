@if(can('shelves.edit'))
    <div id="bulk-actions-btn" class="btn-group d-none">
        <button type="button" class="btn fw-bold btn-secondary dropdown-toggle position-relative" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-square-check"></i>
            {{ __('globals.bulk_actions') }}
            <span id="bulk-actions-count"></span>
        </button>

        <ul class="dropdown-menu">
            <li>
                <a id="bulk-detach-button" class="dropdown-item" href="#" data-action="{{ route('admin.shelves.products.bulk_detach', $shelf->id) }}">
                    <i class="fas fa-minus me-1"></i> <span class="me-3">{{ __('globals.detach') }}</span>
                </a>
            </li>
        </ul>
    </div>

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
