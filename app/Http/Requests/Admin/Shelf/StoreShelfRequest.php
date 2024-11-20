<?php

namespace App\Http\Requests\Admin\Shelf;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreShelfRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'warehouse_id' => ['required', 'exists:warehouses,id'],
            'aisle' => ['required', 'string'],
            'name' => [
                'required',
                'string',
                "starts_with:{$this->aisle}",
                Rule::unique('shelves', 'name')
                    ->where('warehouse_id', $this->warehouse_id),
            ],
            'description' => ['nullable', 'string'],
        ];
    }

    public function attributes()
    {
        return [
            'warehouse_id' => __('admin.shelves.attributes.warehouse_id'),
            'aisle' => __('admin.shelves.attributes.aisle'),
            'name' => __('admin.shelves.attributes.name'),
            'description' => __('admin.shelves.attributes.description'),
        ];
    }
}