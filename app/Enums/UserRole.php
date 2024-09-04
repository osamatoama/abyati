<?php

namespace App\Enums;

use Spatie\Permission\Models\Role;

enum UserRole: string
{
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
