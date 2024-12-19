@php
    $expiryDate = $product->quantities->first()?->expiry_date;
@endphp

{{ $expiryDate ? $expiryDate->format('Y-m-d') : '---' }}
