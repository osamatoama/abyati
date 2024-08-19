<?php

namespace App\Models;

use Carbon\Carbon;
use App\Enums\StoreProviderType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Services\Salla\OAuth\SallaOAuthService;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Token extends Model
{
    use HasFactory;

    /**
     * Config
     */
    protected $fillable = [
        'user_id',
        'provider_type',
        'access_token',
        'refresh_token',
        'expired_at',
    ];

    protected $casts = [
        'provider_type' => StoreProviderType::class,
        'expired_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeSalla(Builder $query): Builder
    {
        return $query->where(
            column: 'provider_type',
            operator: '=',
            value: StoreProviderType::SALLA,
        );
    }

    public function scopeValid(Builder $query): Builder
    {
        return $query->where(
            column: 'expired_at',
            operator: '>',
            value: now(),
        );
    }

    public function scopeInvalid(Builder $query): Builder
    {
        return $query->where(
            column: 'expired_at',
            operator: '<=',
            value: now()->subDays(
                value: 2,
            ),
        );
    }

    protected function accessToken(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes): string {
                if (Carbon::parse($attributes['expired_at'])->lessThanOrEqualTo(now())) {
                    $token = (new SallaOAuthService())->getNewToken(refreshToken: $attributes['refresh_token']);
                    $accessToken = $token->getToken();

                    $this->update([
                        'access_token' => $accessToken,
                        'refresh_token' => $token->getRefreshToken(),
                        'expired_at' => $token->getExpires(),
                    ]);

                    $value = $accessToken;
                }

                return $value;
            },
        );
    }
}
