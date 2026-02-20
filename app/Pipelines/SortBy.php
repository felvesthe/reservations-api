<?php

declare(strict_types=1);

namespace App\Pipelines;

use App\Models\Booking;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Schema;

final class SortBy
{
    /**
     * @param  Builder<Booking>  $query
     * @param  Closure  $next
     * @return Builder<Booking>
     */
    public function __invoke(Builder $query, Closure $next): Builder
    {
        $sortBy = request()->string('sortBy')->toString();
        $sortDirection = request()->string('sortDirection')->toString() ?: 'asc';

        if (empty($sortBy)) {
            return $next($query);
        }

        $columnName = Str::trim(Str::lower($sortBy));

        $columnExists = Schema::hasColumn(
            table: $query->getModel()->getTable(),
            column: $columnName,
        );

        $query->when($columnExists, function (Builder $query) use ($sortDirection, $columnName): void {
            $query->orderBy($columnName, $sortDirection === 'asc' ? 'asc' : 'desc');
        });

        return $next($query);
    }
}
