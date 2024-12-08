<?php

namespace App\Models;

use App\Enums\EmployeeRole;
use App\Models\Concerns\Activatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
        'roles',
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
            'roles' => 'array',
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

    public function shelves(): BelongsToMany
    {
        return $this->belongsToMany(
                related: Shelf::class,
                table: 'employee_shelf',
                foreignPivotKey: 'employee_id',
                relatedPivotKey: 'shelf_id',
            )
            ->withTimestamps();
    }

    /**
     * Scopes
     */
    public function scopeRole(Builder $query, EmployeeRole|string $role): Builder
    {
        $role = $role instanceof EmployeeRole ? $role->value : $role;

        return $query->whereJsonContains('roles', $role);
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

    public function hasRole(EmployeeRole|string $role): bool
    {
        $role = $role instanceof EmployeeRole ? $role->value : $role;

        return in_array($role, $this->roles);
    }
}
