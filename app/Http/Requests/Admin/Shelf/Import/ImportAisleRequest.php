<?php

namespace App\Http\Requests\Admin\Shelf\Import;

use Illuminate\Foundation\Http\FormRequest;

class ImportAisleRequest extends FormRequest
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
            'file' => ['required', 'file', 'mimes:xlsx,xls'],
        ];
    }
}