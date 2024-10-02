@if(filled($support->branch))
    {{ $support->branch->name }}
@else
    ---
@endif
