<?php

declare(strict_types=1);

namespace App\Pipelines\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

final class UserFilter extends Filter
{
    /**
     * @param  Builder<Model>  $query
     * @param  Closure  $next
     * @return Builder<Model>
     */
    public function __invoke(Builder $query, Closure $next): Builder
    {
        $filter = $this->getFilter('user_id');

        $query->when(null !== $filter, function (Builder $query) use ($filter): void {
            $query->where('user_id', $filter);
        });

        return $next($query);
    }
}
