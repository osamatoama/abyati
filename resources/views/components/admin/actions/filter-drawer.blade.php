@props([
    'size' => null,
])

@php
    $btnSize = $size ? "btn-$size" : '';
@endphp

<div>
    <button id="filter-button" class="btn {{ $btnSize }} btn-secondary fw-semibold">
        <i class="fas fa-filter"></i> {{ __('globals.filters') }}
    </button>

    <div id="filter-menu" class="bg-white"
        data-kt-drawer="true" data-kt-drawer-activate="true"
        data-kt-drawer-toggle="#filter-button" data-kt-drawer-close="#filter-menu-close"
        data-kt-drawer-width="350px"
    >
        <div class="card w-100 rounded-0">
            <div class="card-header pe-5">
                <div class="card-title">
                    <div class="d-flex justify-content-center flex-column me-3">
                        <a href="#" class="fs-4 fw-bold text-gray-900 text-hover-primary me-1 lh-1">
                            <i class="fas fa-filter"></i> {{ __("globals.filters") }}
                        </a>
                    </div>
                </div>

                <div class="card-toolbar">
                    <div class="btn btn-sm btn-icon btn-active-light-primary" id="filter-menu-close">
                        <i class="ki-duotone ki-cross fs-2"><span class="path1"></span><span class="path2"></span></i>                </div>
                </div>
            </div>

            <div class="card-body hover-scroll-overlay-y">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
