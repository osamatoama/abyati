<?php

namespace App\Http\Requests\Admin\Support;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSupportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if (! $this->filled('password')) {
            $this->request->remove('password');
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', Rule::unique('supports', 'email')->ignore($this->route('support')->id)],
            'phone' => ['nullable', 'string'],
            'password' => [
                'nullable',
                'string',
                Password::min(8)
                    ->letters()
                    ->numbers()
                    ->symbols(),
            ],
        ];
    }

    public function attributes()
    {
        return [
            'name' => __('admin.supports.attributes.name'),
            'email' => __('admin.supports.attributes.email'),
            'phone' => __('admin.supports.attributes.phone'),
            'password' => __('admin.supports.attributes.password'),
        ];
    }
}
