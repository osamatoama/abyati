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

    <select class="form-select form-select-solid" name="{{ $name }}" id="{{ $id }}"
        data-control="select2" data-placeholder="{{ $placeholder }}" data-close-on-select="false"
        @if($multiple) multiple="multiple" @endif
        @if(filled($parent)) data-dropdown-parent="{{ $parent }}" @endif
        {{ $attributes }}
    >
        <option selected disabled>اختر المنتج</option>
        @foreach ($products as $productId => $productName)
            <option value="{{ $productId }}">{{ $productName }}</option>
        @endforeach
    </select>

    <span id="{{ $id }}-error" class="form-input-error text-danger d-none"></span>
</div>
