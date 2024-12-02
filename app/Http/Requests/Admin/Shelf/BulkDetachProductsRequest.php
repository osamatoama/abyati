<?php

namespace App\Http\Requests\Admin\Shelf;

use Illuminate\Foundation\Http\FormRequest;

class BulkDetachProductsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'product_ids' => explode(',', $this->ids),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_ids' => ['array'],
            'product_ids.*' => ['required', 'integer', 'exists:products,id'],
        ];
    }
}
