<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'user_id' => ['required'],
            'name' => ['required', 'string'],
            'email' => ['required', 'email', Rule::unique('employees', 'email')->whereNot('id', $this->employee->id)],
            'phone' => ['nullable', 'string'],
            'password' => ['nullable', 'string', Password::min(8)
                ->letters()
                ->numbers()
                ->symbols(),
            ],
            'role_id' => ['required', 'integer', Rule::exists('roles', 'id')],
        ];
    }
}
