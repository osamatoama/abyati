<?php

namespace App\Models\Concerns;

use App\Models\Filters\BaseFilters;
use Illuminate\Support\Facades\App;

trait Filterable
{
    /**
     * Apply all relevant thread filters.
     */
    public function scopeFilter($query, BaseFilters $filters = null, $appendedFilters = [])
    {
        if (!$filters) {
            $filters = App::make($this->filter);
        }

        return $filters->apply($query, $appendedFilters);
    }
}
