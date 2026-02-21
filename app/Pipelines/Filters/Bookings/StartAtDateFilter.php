<?php

declare(strict_types=1);

namespace App\Pipelines\Filters\Bookings;

use App\Pipelines\Filters\DateFilter;
use App\Pipelines\Filters\Filter;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

final class StartAtDateFilter extends Filter
{
    /**
     * @param  Builder<Model>  $query
     * @param  Closure  $next
     * @return Builder<Model>
     */
    public function __invoke(Builder $query, Closure $next): Builder
    {
        return app(DateFilter::class)(
            columnName: 'start_at',
            query: $query,
            next: $next
        );
    }
}
