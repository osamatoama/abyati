@if(filled($employee->phone))
    <span dir="ltr">{{ $employee->phone }}</span>
@else
    -----
@endif
