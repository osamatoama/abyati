<?php

namespace App\Http\Requests\Admin\Role;

use App\Rules\ShouldHaveNoRelations;
use Illuminate\Foundation\Http\FormRequest;

class DeleteRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->route('role')->isDeletable();
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'has_no_relations' => 1,
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
            'has_no_relations' => [new ShouldHaveNoRelations(
                model: $this->route('role'),
                relations: ['users'],
                msg: __('admin.roles.errors.should_have_no_relations'),
            )],
        ];
    }
}
