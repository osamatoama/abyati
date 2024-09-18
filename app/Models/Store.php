<?php

namespace App\Models;

use App\Models\User;
use App\Enums\StoreProviderType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Store extends Model
{
    use HasFactory;

    /**
     * Constants
     */
    const DEFAULT_ID_COLOR = '#ffffff';

    const CACHE_STORES_ID_COLORS_KEY = 'stores:id_colors';

    /**
     * Config
     */
    protected $fillable = [
        'user_id',
        'provider_type',
        'provider_id',
        'name',
        'mobile',
        'email',
        'domain',
        'id_color',
    ];

    protected $casts = [
        'provider_type' => StoreProviderType::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            related: User::class,
            foreignKey: 'user_id',
            ownerKey: 'id',
        );
    }

    public function orderStatuses(): HasMany
    {
        return $this->hasMany(OrderStatus::class, 'store_id');
    }

    public function scopeSalla(Builder $query, ?int $providerId = null): Builder
    {
        return $query->where(
            column: 'provider_type',
            operator: '=',
            value: StoreProviderType::SALLA,
        )->when(
            value: $providerId !== null,
            callback: fn (Builder $query): Builder => $query->where(
                column: 'provider_id',
                operator: '=',
                value: $providerId,
            ),
        );
    }
}
