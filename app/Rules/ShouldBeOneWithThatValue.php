<?php

namespace App\Rules;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\ValidationRule;

class ShouldBeOneWithThatValue implements ValidationRule
{
    public function __construct(
        private $tableName,
        private $column,
        private $value,
        private $wheres,
        private $msg,
        private $updatingId
    )
    {
        //
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
        if ($value != $this->value) {
            return DB::table($this->tableName)
                ->where($this->wheres)
                ->where("id", "!=", $this->updatingId)
                ->where($this->column, "=", $this->value)
                ->exists();
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
