@props([
    'id' => '',
    'name' => '',
    'label' => '',
    'placeholder' => '',
    'multiple' => false,
    'parent' => null,
    'value' => null,
])


<div>
    <label for="{{ $id }}" class="form-label">
        {{ $label }}
    </label>

    <select class="form-select form-select-solid" name="status_ids[]" id="{{ $id }}"
        data-control="select2" data-placeholder="{{ $placeholder }}" data-close-on-select="false"
        @if($multiple) multiple="multiple" @endif
        @if(filled($parent)) data-dropdown-parent="{{ $parent }}" @endif
        {{ $attributes }}
    >
        @foreach ($statuses as $status)
            <option value="{{ $status->id }}">{{ $status->name }}</option>
        @endforeach
    </select>

    <span id="{{ $id }}-error" class="form-input-error text-danger d-none"></span>

    <div class="d-flex">
        <a href="#" id="{{ $id }}-select-all" class="badge badge-light-success my-3 me-5">
            <i class="fa-solid fa-check me-1"></i>
            @lang("globals.select_all")
        </a>

        <a href="#" id="{{ $id }}-clear-all" class="badge badge-light-danger my-3 me-5">
            <i class="fa-solid fa-xmark me-1"></i>
            @lang("globals.clear_all")
        </a>
    </div>
</div>
