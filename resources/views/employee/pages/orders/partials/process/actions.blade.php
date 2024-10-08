
<div class="d-flex align-items-center position-relative my-1 ms-2">
    <button class="btn btn-primary me-3" data-bs-toggle="modal" data-bs-target="#scan-modal">
        <i class="fas fa-barcode"></i> {{ __('employee.orders.actions.scan_barcode') }}
    </button>

    <a href="{{ route('employee.orders.index') }}" class="btn btn-light">
        <i class="fas fa-arrow-left pe-0"></i> {{ __('globals.back') }}
    </a>
</div>
