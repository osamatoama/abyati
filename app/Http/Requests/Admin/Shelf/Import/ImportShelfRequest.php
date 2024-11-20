<?php

namespace App\Http\Requests\Admin\Shelf\Import;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ImportShelfRequest extends FormRequest
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
            'shelf_id' => ['required', Rule::exists('shelves', 'id')->where('warehouse_id', $this->warehouse_id)],
            'file' => ['required', 'file', 'mimes:xlsx,xls'],
        ];
    }
}
