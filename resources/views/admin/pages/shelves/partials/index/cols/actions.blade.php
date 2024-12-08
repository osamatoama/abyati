@if(can('shelves.show'))
    <x-admin.table.actions.show-button
        :href="route('admin.shelves.show',  $shelf->id)"
    />
@endif

@if(can('shelves.edit'))
    <x-admin.table.actions.edit-button
        data-action="{{ route('admin.shelves.update', $shelf->id) }}"
        data-warehouse_id="{{ $shelf->warehouse_id }}"
        data-name="{{ $shelf->name }}"
        data-aisle="{{ $shelf->aisle }}"
        data-description="{{ $shelf->description }}"
        data-employee_ids="{{ json_encode($shelf->employees->pluck('id')->toArray()) }}"
    />
@endif

@if(can('shelves.delete'))
    @php
        // $enabled = $branch->employees_count == 0 && $branch->orders_count == 0;
        $enabled = true;
    @endphp

    <x-admin.table.actions.delete-button
        :action="route('admin.shelves.destroy',  $shelf->id)"
        :showTooltip="! $enabled"
        :tooltip="__('admin.shelves.errors.should_have_no_relations')"
        :disabled="! $enabled"
    />
@endif
