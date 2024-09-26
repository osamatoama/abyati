<?php

namespace App\Models\Concerns;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToUser
{
    /**
     * Relations
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    /**
     * Scopes
     */
    public function scopeMine($query)
    {
        return $query->where('user_id', auth('admin')->id());
    }

    public function scopeForUser($query, string $userId)
    {
        $query->where('user_id', $userId);
    }
}
