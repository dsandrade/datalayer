<?php

namespace OneGiba\DataLayer\Traits;

use Illuminate\Database\Eloquent\Builder;
use OneGiba\DataLayer\Filters\QueryFilters;

trait Filterable
{
    /**
     * Filter a result set.
     *
     * @param  \Illuminate\Database\Eloquent\Builder   $query
     * @param  \OneGiba\DataLayer\Filters\QueryFilters $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter(Builder $query, QueryFilters $filters)
    {
        return $filters->apply($query);
    }
}