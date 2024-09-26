<?php

namespace App\Http\Requests\Admin\Employee;

use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:employees,email'],
            'phone' => ['nullable', 'string'],
            'password' => [
                'required',
                'string',
                Password::min(8)
                    ->letters()
                    ->numbers()
                    ->symbols(),
            ],
            'branch_id' => ['required', 'exists:branches,id'],
        ];
    }

    public function attributes()
    {
        return [
            'name' => __('admin.employees.attributes.name'),
            'email' => __('admin.employees.attributes.email'),
            'phone' => __('admin.employees.attributes.phone'),
            'password' => __('admin.employees.attributes.password'),
            'role' => __('admin.employees.attributes.role'),
        ];
    }
}
