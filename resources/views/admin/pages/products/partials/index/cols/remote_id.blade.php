@php
    $remoteId = $product->remote_id;
@endphp

@if(filled($remoteId) && filled($product->admin_url))
    <a href="{{ $product->admin_url }}" target="_blank">
        {{ $remoteId }}
    </a>
@elseif(filled($remoteId))
    {{ $remoteId }}
@else
    -----
@endif
