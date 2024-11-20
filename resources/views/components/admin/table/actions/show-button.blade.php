@props([
    'href' => '#',
    'url' => null,
    'jsClass' => 'show-row-button',
    'showTooltip' => true,
    'tooltip' => __('globals.show'),
])

@php
    $url = filled($url) ? "data-url='$url'" : '';
    $tooltip = ($showTooltip && filled($tooltip))
        ? "data-bs-toggle='tooltip' data-bs-placement='top' title='$tooltip'"
        : "";
@endphp

<a
    href="{{ $href }}" {!! $url !!}
    class="{{ $jsClass }} btn btn-outline btn-outline-info btn-sm"
    {!! $tooltip !!}
    {{ $attributes }}
>
    <i class="fas fa-eye pe-0"></i>
</a>
