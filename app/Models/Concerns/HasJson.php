<?php

namespace App\Models\Concerns;

trait HasJson
{
    public function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }
}
