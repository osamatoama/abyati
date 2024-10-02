@if(filled($execution->started_at))
    <p class="order-date mb-0 text-nowrap">
        <span dir="ltr">{{ $execution->started_at->format('Y-m-d h:i a') }}</span>
    </p>
@else
    ---
@endif
