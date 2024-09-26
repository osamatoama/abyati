@if(filled($store->domain))
    <a href="{{ $store->domain }}" target="_blank">
        {{ $store->domain }}
    </a>
@else
    ---
@endif
