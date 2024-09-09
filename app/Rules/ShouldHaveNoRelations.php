<?php

namespace App\Rules;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Validation\ValidationRule;

class ShouldHaveNoRelations implements ValidationRule
{
    public function __construct(
        private Model $model,
        private array $relations,
        private string $msg
    )
    {
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        foreach ($this->relations as $relation) {
            if (method_exists($this->model, $relation) && $this->model->$relation()->exists()) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param string $attribute
     * @param mixed $value
     * @param Closure $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->passes($attribute, $value)) {
            $fail($this->message());
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->msg;
    }
}
