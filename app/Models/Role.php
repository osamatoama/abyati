<?php

namespace App\Models;

use App\Models\Concerns\BelongsToUser;
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
}
