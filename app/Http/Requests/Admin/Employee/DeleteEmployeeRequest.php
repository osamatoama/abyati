<?php

namespace App\Http\Requests\Admin\Employee;

use App\Rules\ShouldHaveNoRelations;
use Illuminate\Foundation\Http\FormRequest;

class DeleteEmployeeRequest extends FormRequest
{
    private $employee;

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
     * @return array
     */
    public function rules()
    {
        return [
            /**
             * TODO: Uncomment the following line after creating the rule.
             */
            // 'has_no_relations' => [new ShouldHaveNoRelations(
            //     model: $this->employee,
            //     relations: ['orderStatuses'],
            //     msg: __('employees.messages.should_have_no_relations'),
            // )],
        ];
    }
}
