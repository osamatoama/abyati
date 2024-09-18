<?php

namespace App\Models;

use App\Enums\UserRole;
use App\Models\Concerns\BelongsToUser;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use BelongsToUser;

    /**
     * Config
     */
    protected $fillable = [
        'user_id',
        'name',
        'guard_name',
    ];

    /**
     * Scopes
     */
    public function scopeAssignable(Builder $builder)
    {
        $builder->whereNotIn('name', UserRole::values());
    }

    /**
     * Helpers
     */
    public function isEditable(): bool
    {
        return ! in_array($this->name, UserRole::values());
    }

    public function isDeletable(): bool
    {
        return ! in_array($this->name, UserRole::values());
    }
}
