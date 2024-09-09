@if(filled($employee->branch))
    {{ $employee->branch->name }}
@else
    ---
@endif
