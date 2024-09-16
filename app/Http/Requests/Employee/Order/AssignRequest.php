<?php

namespace App\Http\Requests\Employee\Order;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AssignRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->route('order')->isNotAssigned();
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'employee_id' => auth('employee')->id(),
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
            'employee_id' => [
                'required',
                Rule::exists('employees', 'id')->where('active', true),
            ],
        ];
    }
}
