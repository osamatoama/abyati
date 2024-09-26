<table class="table">
    <thead class="fw-bold">
        <tr>
            <th>{{ __('employee.orders.history.attributes.status') }}</th>
            <th>{{ __('employee.orders.history.attributes.note') }}</th>
            <th>{{ __('employee.orders.history.attributes.date') }}</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($histories as $history)
            <tr class="border-top">
                <td>{{ $history->status->name }}</td>
                <td>{{ filled($history->note) ? $history->note : '-----' }}</td>
                <td>
                    <span dir="ltr">
                        {{ $history->date->format('Y-m-d h:i a') }}
                    </span>
                    <br>
                    <span class="badge badge-sm badge-primary">
                        {{ $history->date->diffForHumans() }}
                    </span>
                </td>
            </tr>
        @empty
            <tr class="border-top">
                <td colspan="4" class="text-center">
                    {{ __('globals.no_data_found') }}
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
