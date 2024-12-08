<?php

namespace App\Http\Requests\Employee\Shelf;

use Illuminate\Foundation\Http\FormRequest;

class AttachProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->route('shelf')?->employees->contains('id', auth('employee')->id());
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
