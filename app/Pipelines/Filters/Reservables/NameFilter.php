<?php

declare(strict_types=1);

namespace App\Pipelines\Filters\Reservables;

use App\Pipelines\Filters\Filter;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

final class NameFilter extends Filter
{
    /**
     * @param  Builder<Model>  $query
     * @param  Closure  $next
     * @return Builder<Model>
     */
    public function __invoke(Builder $query, Closure $next): Builder
    {
        $filter = $this->getFilter('name');

        $query->when(null !== $filter, function (Builder $query) use ($filter): void {
            /** @var string $filter */
            $value = '%' . mb_trim($filter) . '%';

            $query->whereLike('name', $value);
        });

        return $next($query);
    }
}
