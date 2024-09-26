@if(filled($user->roles->first()))
    {{ $user->roles->first()->name }}
@else
    ---
@endif
