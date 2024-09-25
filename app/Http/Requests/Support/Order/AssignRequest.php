<?php

namespace App\Http\Requests\Support\Order;

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
            'support_id' => auth('support')->id(),
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
            'support_id' => [
                'required',
                Rule::exists('supports', 'id')->where('active', true),
            ],
        ];
    }
}
