@props([
    'href' => '#',
    'action' => null,
    'jsClass' => 'delete-row-button',
    'showTooltip' => true,
    'tooltip' => __('buttons.general.crud.delete'),
    'disabled' => false,
])

@php
    $action = filled($action) ? "data-action='$action'" : '';
    $tooltip = ($showTooltip && filled($tooltip))
        ? "data-bs-toggle='tooltip' data-bs-placement='top' title='$tooltip'"
        : "";
    $disabledClass = $disabled ? 'disabled' : '';
@endphp

<span class="delete-row-button-wrapper" {!! $tooltip !!}>
    <a
        href="{{ $href }}" {!! $action !!}
        class="{{ $jsClass }} btn btn-outline btn-outline-danger btn-sm {!! $disabledClass !!}"
        {{ $attributes }}
    >
        <i class="fas fa-trash pe-0"></i>
    </a>
</span>
