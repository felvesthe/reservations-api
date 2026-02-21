<?php

declare(strict_types=1);

namespace App\Pipelines\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

final class ReservableFilter extends Filter
{
    /**
     * @param  Builder<Model>  $query
     * @param  Closure $next
     * @return Builder<Model>
     */
    public function __invoke(Builder $query, Closure $next): Builder
    {
        $filter = $this->getFilter('reservable_id');

        $query->when(null !== $filter, function (Builder $query) use ($filter): void {
            $query->where('reservable_id', $filter);
        });

        return $next($query);
    }
}
