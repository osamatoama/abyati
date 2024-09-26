<?php

namespace App\Http\Requests\Admin\Role;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->route('role')->isEditable();
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'guard_name' => 'admin',
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
            'guard_name' => ['required'],
            'name' => ['required', 'string', Rule::unique('roles', 'name')->ignore($this->role->id, 'id')],
            'permissions' => ['required', 'array'],
            'permissions.*' => ['required', 'integer', 'exists:permissions,id'],
        ];
    }

    public function attributes()
    {
        return [
            'name' => __('admin.roles.attributes.name'),
            'permissions' => __('admin.roles.attributes.permissions'),
        ];
    }
}
