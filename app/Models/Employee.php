<?php

namespace App\Models;

use App\Models\Concerns\Activatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    use Activatable;

    /**
     * Config
     */
    protected $fillable = [
        'branch_id',
        'name',
        'email',
        'phone',
        'email_verified_at',
        'password',
        'active',
        'current_assigned_order_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    /**
     * Relations
     */
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function currentAssignedOrder(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'current_assigned_order_id');
    }

    /**
     * Methods
     */
    public function canAccessAllOrders(): bool
    {
        $accessEmails = app()->isProduction() ? [
            'abobakr.sadig96@gmail.com'
        ] : [
            'employee-1@abyati.com',
        ];

        return in_array($this->email, $accessEmails);
    }
}
