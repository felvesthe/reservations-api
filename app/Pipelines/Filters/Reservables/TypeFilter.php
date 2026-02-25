<?php

declare(strict_types=1);

namespace App\Pipelines\Filters\Reservables;

use App\Pipelines\Filters\Filter;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

final class TypeFilter extends Filter
{
    /**
     * @param  Builder<Model>  $query
     * @param  Closure  $next
     * @return Builder<Model>
     */
    public function __invoke(Builder $query, Closure $next): Builder
    {
        $filter = $this->getFilter('type');

        $query->when(null !== $filter, function (Builder $query) use ($filter): void {
            $query->where('type', $filter);
        });

        return $next($query);
    }
}
