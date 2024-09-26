<?php

namespace App\Models\Filters;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Class BaseFilters
 * @package App\Classes
 */
abstract class BaseFilters
{
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * The Eloquent builder.
     *
     * @var \Illuminate\Database\Eloquent\Builder
     */
    protected $builder;

    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [];

    /**
     * Create a new BaseFilters instance.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Apply the filters.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply($builder, $appendedFilters = [])
    {
        $this->builder = $builder;
        foreach ($this->getFilters() as $filter) {
            $value = $this->request->query($filter) ?? $appendedFilters[$filter] ?? null;
            
            if ($this->request->has($filter) || isset($appendedFilters[$filter])) {
                $methodName = Str::camel($filter);
            } else {
                $methodName = 'default' . Str::studly($filter);
            }

            if (method_exists($this, $methodName)) {
                $this->$methodName($value);
            }
        }

        return $this->builder;
    }

    /**
     * Fetch all relevant filters from the request.
     *
     * @return array
     */
    public function getFilters()
    {
        return property_exists($this, 'filters')
        && is_array($this->filters) ? $this->filters : [];
    }
}
