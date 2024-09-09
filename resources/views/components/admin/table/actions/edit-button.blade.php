@props([
    'href' => '#',
    'url' => null,
    'jsClass' => 'edit-row-button',
    'showTooltip' => true,
    'tooltip' => __('buttons.general.crud.edit'),
])

@php
    $url = filled($url) ? "data-url='$url'" : '';
    $tooltip = ($showTooltip && filled($tooltip))
        ? "data-bs-toggle='tooltip' data-bs-placement='top' title='$tooltip'"
        : "";
@endphp

<a
    href="{{ $href }}" {!! $url !!}
    class="{{ $jsClass }} btn btn-outline btn-outline-primary btn-sm"
    {!! $tooltip !!}
    {{ $attributes }}
>
    <i class="fas fa-edit pe-0"></i>
</a>
