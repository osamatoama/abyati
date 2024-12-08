<?php

namespace App\Http\Requests\Admin\Employee;

use App\Enums\EmployeeRole;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
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
            'email' => ['required', 'email', Rule::unique('employees', 'email')->ignore($this->route('employee')->id)],
            'phone' => ['nullable', 'string'],
            'password' => [
                'nullable',
                'string',
                Password::min(8)
                    ->letters()
                    ->numbers()
                    ->symbols(),
            ],
            'branch_id' => ['required', 'exists:branches,id'],
            'roles' => ['required', 'array'],
            'roles.*' => ['required', 'string', EmployeeRole::toValidationRule()],
        ];
    }

    public function attributes()
    {
        return [
            'name' => __('admin.employees.attributes.name'),
            'email' => __('admin.employees.attributes.email'),
            'phone' => __('admin.employees.attributes.phone'),
            'password' => __('admin.employees.attributes.password'),
            'branch_id' => __('admin.employees.attributes.branch'),
            'roles' => __('admin.employees.attributes.roles'),
        ];
    }
}
