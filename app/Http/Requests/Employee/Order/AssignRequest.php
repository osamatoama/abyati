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
        $order = $this->route('order');

        return $order->isBranchMine() && $order->isNotAssigned();
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
                Rule::exists('employees', 'id')
                    ->where('id', $this->route('order')->employee_id)
                    ->where('branch_id', $this->route('order')->branch_id)
                    ->where('active', true),
            ],
        ];
    }
}
