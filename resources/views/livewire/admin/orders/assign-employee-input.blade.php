<div wire:key="{{ $order->id }}" class="assign-employee-row">
    <div wire:ignore>
        <select
            id="assign-employee-{{ $order->id }}"
            class="form-control"
            @disabled(! $enable_assign)
        >
            @if(empty($employee_id))
                <option selected disabled>---</option>
            @endif

            @foreach($employees as $employeeId => $employeeName)
                <option value="{{ $employeeId }}" @if($employeeId == $employee_id) selected @endif>{{ $employeeName }}</option>
            @endforeach
        </select>
    </div>

    @error('employee_id')
        <div class="form-input-error text-danger">{{ $message }}</div>
    @enderror
</div>

@script
    <script>
        $('#assign-employee-{{ $order->id }}').select2({
            placeholder: '{{ __('globals.select') }}',
        })

        $('#assign-employee-{{ $order->id }}').on('change', function() {
            @this.set('employee_id', $('#assign-employee-{{ $order->id }}').val())
        })
    </script>
@endscript
