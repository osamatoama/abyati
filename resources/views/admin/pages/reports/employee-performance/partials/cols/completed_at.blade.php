@if(filled($execution->completed_at))
    <p class="order-date mb-0 text-nowrap">
        <span dir="ltr">{{ $execution->completed_at->format('Y-m-d h:i a') }}</span>
    </p>
@else
    ---
@endif
