@if(can('orders.edit'))
    <div class="btn-group">
        <button type="button" class="btn fw-bold btn-secondary dropdown-toggle position-relative" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-briefcase"></i>
            {{ __('globals.services') }}
        </button>

        <ul class="dropdown-menu">
            @if(can('orders.edit'))
                <li>
                    <a href="javascript:void(0)" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#pull-orders-modal">
                        <i class="fas fa-download me-1"></i> <span class="me-3">{{ __('orders.pull_form.pull_orders') }}</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
@endif

<x-admin.actions.filter-drawer>
    <form action="{{ route('admin.orders.index') }}">
        <div class="mb-10">
            <label for="status" class="form-label">
                {{ __("orders.attributes.status") }}
            </label>
            <select class="form-select" id="status" name="status">
                <option value="">{{ __("orders.attributes.status") }}</option>
                @foreach($statuses as $key => $status)
                    <option value="{{$status->id}}" {{ request('status') == $status->id ? 'selected' : '' }}>{{$status->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="d-flex justify-content-end">
            <a href="{{ route('admin.orders.index') }}"
                class="btn btn-sm btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true">
                {{ __("globals.reset") }}
            </a>
            <button type="submit" class="btn btn-sm btn-primary" data-kt-menu-dismiss="true">
                {{ __("globals.apply") }}
            </button>
        </div>
    </form>
</x-admin.actions.filter-drawer>
