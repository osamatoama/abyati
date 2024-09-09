@props([
    'href' => '#',
    'action' => null,
    'jsClass' => 'restore-row-button',
    'showTooltip' => true,
    'tooltip' => __('buttons.globals.crud.restore'),
])

@php
    $action = filled($action) ? "data-action='$action'" : '';
    $tooltip = ($showTooltip && filled($tooltip))
        ? "data-bs-toggle='tooltip' data-bs-placement='top' title='$tooltip'"
        : "";
@endphp

<a
    href="{{ $href }}" {!! $action !!}
    class="{{ $jsClass }} btn btn-outline btn-outline-success btn-sm"
    {!! $tooltip !!}
    {{ $attributes }}
>
    <i class="fas fa-trash-restore pe-0"></i>
</a>
