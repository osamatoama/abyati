@props([
    'text' => '',
    'limit' => 10,
])

<span>
    @if(strlen($text) > $limit)
        {{ Str::limit($text, $limit, '') }}
        <button type="button" class="show-more-tooltip btn btn-light py-0 px-1" 
            data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" 
            data-bs-placement="top" title="{{ $text }}"
        >
            ...
        </button>
    @else
        {{ $text }}
    @endif
</span>