<?php

namespace App\Models;

use App\Models\User;
use App\Enums\StoreProviderType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
        'is_supplier',
        'id_color',
    ];

    protected $casts = [
        'provider_type' => StoreProviderType::class,
        'is_supplier' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            related: User::class,
            foreignKey: 'user_id',
            ownerKey: 'id',
        );
    }

    /**
     * Relationships
     */
    public function orderStatuses(): HasMany
    {
        return $this->hasMany(OrderStatus::class, 'store_id');
    }

    public function branches(): BelongsToMany
    {
        return $this->belongsToMany(
                related: Branch::class,
                table: 'branch_order_statuses',
                foreignPivotKey: 'store_id',
                relatedPivotKey: 'branch_id',
            )
            ->withPivot('order_status_id');
    }

    public function branchOrderStatuses(): BelongsToMany
    {
        return $this->belongsToMany(
                related: OrderStatus::class,
                table: 'branch_order_statuses',
                foreignPivotKey: 'store_id',
                relatedPivotKey: 'order_status_id',
            )
            ->withPivot('branch_id');
    }

    /**
     * Scopes
     */
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

    public function scopeSupplier(Builder $query): Builder
    {
        return $query->where(
            column: 'is_supplier',
            operator: '=',
            value: true,
        );
    }

    public function scopeRetailer(Builder $query): Builder
    {
        return $query->where(
            column: 'is_supplier',
            operator: '=',
            value: false,
        );
    }

    /**
     * Helpers
     */
    public function isSupplier(): bool
    {
        return $this->is_supplier;
    }

    public function isRetailer(): bool
    {
        return ! $this->is_supplier;
    }
}
