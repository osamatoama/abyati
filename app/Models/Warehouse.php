<?php

namespace App\Models;

use App\Models\Concerns\Activatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warehouse extends Model
{
    use SoftDeletes;
    use Activatable;

    /**
     * Config
     */
    protected $table = 'warehouses';

    protected $fillable = [
        'branch_id',
        'name',
        'active',
        'is_default',
    ];

    protected $casts = [
        'active' => 'boolean',
        'is_default' => 'boolean',
    ];

    /**
     * Relationships
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function shelves()
    {
        return $this->hasMany(Shelf::class);
    }

    /**
     * Methods
     */
    public function getAisles(): array
    {
        return $this->shelves
            ->pluck('aisle')
            ->unique()
            ->sort()
            ->values()
            ->toArray();
    }
}
