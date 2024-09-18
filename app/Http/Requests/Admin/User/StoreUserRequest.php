<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'email' => ['required', 'email', Rule::unique('employees', 'email')],
            'phone' => ['nullable', 'string'],
            'password' => ['required', 'string', Password::min(8)
                ->letters()
                ->numbers()
                ->symbols(),
            ],
            'role_id' => ['required', 'integer', Rule::exists('roles', 'id')],
        ];
    }
}
