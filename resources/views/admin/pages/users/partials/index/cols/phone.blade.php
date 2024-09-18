@if(filled($user->phone))
    <span dir="ltr">{{ $user->phone }}</span>
@else
    -----
@endif
