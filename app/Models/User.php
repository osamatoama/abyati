<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserRole;
use App\Enums\StoreProviderType;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
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
    public function store(): HasOne
    {
        return $this->hasOne(
            related: Store::class,
            foreignKey: 'user_id',
            localKey: 'id',
        );
    }

    public function providerTokens(): HasMany
    {
        return $this->hasMany(
            related: Token::class,
            foreignKey: 'user_id',
            localKey: 'id',
        );
    }

    public function sallaToken(): HasOne
    {
        return $this->hasOne(
            related: Token::class,
            foreignKey: 'user_id',
            localKey: 'id',
        )->where(
            column: 'provider_type',
            operator: '=',
            value: StoreProviderType::SALLA,
        )->ofMany();
    }

    // public function scopeCanAccessDashboard(Builder $query): Builder
    // {
    //     return $this->scopeRole(
    //         query: $query,
    //         roles: [
    //             UserRole::ADMIN->asModel(),
    //             UserRole::MERCHANT->asModel(),
    //         ],
    //     );
    // }

    // public function canAccessPanel(Panel $panel): bool
    // {
    //     if ($panel->getId() === 'admin') {
    //         return $this->hasRole(
    //             roles: UserRole::ADMIN->asModel(),
    //         );
    //     }

    //     return false;
    // }

    public function scopeAdmin(Builder $query): Builder
    {
        return $this->scopeRole(
            query: $query,
            roles: [
                UserRole::ADMIN->asModel(),
            ],
        );
    }

    public function scopeMerchant(Builder $query): Builder
    {
        return $this->scopeRole(
            query: $query,
            roles: [
                UserRole::MERCHANT->asModel(),
            ],
        );
    }

    public function isSuperAdmin()
    {
        return $this->id == 1;
    }

    protected function isAdmin(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes): bool => $this->hasRole(
                roles: UserRole::ADMIN->asModel(),
            ),
        );
    }

    protected function isMerchant(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes): bool => $this->hasRole(
                roles: UserRole::MERCHANT->asModel(),
            ),
        );
    }
}
