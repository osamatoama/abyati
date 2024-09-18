<?php

namespace App\Enums;

use App\Models\Role;
use App\Enums\Concerns\InteractsWithArrays;

enum UserRole: string
{
    use InteractsWithArrays;

    case ADMIN = 'admin';
    case MERCHANT = 'merchant';

    public function guardName(): string
    {
        return 'admin';
    }

    public function asModel(): Role
    {
        return once(
            callback: fn(): Role => Role::query()
                ->where(
                    column: 'name',
                    operator: '=',
                    value: $this->value,
                )
                ->where(
                    column: 'guard_name',
                    operator: '=',
                    value: $this->guardName(),
                )
                ->first(),
        );
    }
}
