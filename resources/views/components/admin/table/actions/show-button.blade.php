@props([
    'href' => '#',
    'url' => null,
    'id' => null,
    'jsClass' => 'show-row-button',
    'showTooltip' => true,
    'tooltip' => __('globals.show'),
])

@php
    $id = filled($id) ? "id='$id'" : '';
    $url = filled($url) ? "data-url='$url'" : '';
    $tooltip = ($showTooltip && filled($tooltip))
        ? "data-bs-toggle='tooltip' data-bs-placement='top' title='$tooltip'"
        : "";
@endphp

<a
    href="{{ $href }}" {!! $url !!} {!! $id !!}
    class="{{ $jsClass }} btn btn-outline btn-outline-info btn-sm"
    {!! $tooltip !!}
    {{ $attributes }}
>
    <i class="fas fa-eye pe-0"></i>
</a>
