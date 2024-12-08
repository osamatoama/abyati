@if($shelf->employees->isNotEmpty())
    <ol>
        @foreach($shelf->employees as $employee)
            <li>{{ $employee->name }}</li>
        @endforeach
    </ol>
@else
    ---
@endif
