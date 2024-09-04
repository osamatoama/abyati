<?php

namespace App\Services\Concerns;

trait HasInstance
{
    public static function instance(bool $singleton = true): static
    {
        if (! $singleton) {
            return new static();
        }

        app()->singletonIf(
            abstract: static::class,
        );

        return resolve(
            name: static::class,
        );
    }
}
