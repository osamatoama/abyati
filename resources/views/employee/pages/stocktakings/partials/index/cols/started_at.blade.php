@if($stocktaking->started_at)
    <p class="order-date mb-0 text-nowrap">
        <span dir="ltr">{{ $stocktaking->started_at->format('Y-m-d') }}</span>
    </p>
    <p class="order-date mb-1 text-nowrap">
        <span dir="ltr">{{ $stocktaking->started_at->format('h:i a') }}</span>
    </p>
    <p class="order-date-diff mb-0 fst-italic text-muted">
        {{ $stocktaking->started_at->diffForHumans() }}
    </p>
@else
    ---
@endif
