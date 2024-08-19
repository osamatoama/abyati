<?php

namespace App\Models;

// use Filament\Panel;
use App\Models\Concerns\Activatable;
use Illuminate\Notifications\Notifiable;
// use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

// class Employee extends Authenticatable implements FilamentUser
class Employee extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    use Activatable;

    /**
     * Config
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'email_verified_at',
        'password',
        'active',
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

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Helpers
     */
    // public function canAccessPanel(Panel $panel): bool
    // {
    //     if ($panel->getId() === 'marketer') {
    //         return $this->isActive();
    //     }

    //     return false;
    // }
}
