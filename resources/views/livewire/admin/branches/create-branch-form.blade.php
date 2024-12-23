<div>
    <form wire:submit.prevent="save">
        <div class="form-group mt-3 row">
            <label class="col-md-2 form-label form-control-lg">{{ __('admin.branches.attributes.name') }}</label>
            <div class="col-md-10">
                <input type="text" class="form-control" wire:model="name">

                @error('name')
                    <span class="form-input-error text-danger"></span>
                @enderror
            </div>
        </div>

        <div class="py-5">
            <h3 class="mb-5">
                {{ __('admin.branches.attributes.related_order_status') }}
            </h3>

            @foreach($stores as $store)
                <div class="form-group mt-3 row">
                    <label class="col-md-2 form-label form-control-lg">{{ $store->name }}</label>
                    <div class="col-md-10">
                        <select class="form-control" wire:model="order_statuses.{{ $store->id }}">
                            <option value="" disabled> {{ __('globals.select') }}</option>

                            @foreach($store->orderStatuses as $orderStatus)
                                <option value="{{ $orderStatus->id }}">{{ $orderStatus->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endforeach
        </div>

        <div>
            <a href="{{ route('admin.branches.index') }}" class="btn btn-secondary">
                {{ __('globals.close') }}
            </a>
            <button type="submit" class="btn btn-primary">
                {{ __('globals.save') }}
            </button>
        </div>
    </form>
</div>
