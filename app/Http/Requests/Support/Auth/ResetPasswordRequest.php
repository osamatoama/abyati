<?php

namespace App\Http\Requests\Support\Auth;

use App\Models\Support;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'current_password' => ['required', "current_password:support"],
            'new_password' => ['required',
                "not_in:$this->current_password",
                Password::min(8)
                    ->letters()
                    ->numbers()
                    ->symbols(),
                'confirmed',
            ],
        ];
    }

    public function attributes()
    {
        return [
            'current_password' => __('account.attributes.current_password'),
            'new_password' => __('account.attributes.new_password'),
        ];
    }

    public function messages()
    {
        return [
            'new_password.not_in' => __('account.messages.new_password_same_as_current'),
        ];
    }
}
