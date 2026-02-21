<?php

declare(strict_types=1);

namespace App\Pipelines\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Schema;

final class DateFilter extends Filter
{
    /**
     * @param  string  $columnName
     * @param  Builder<Model>  $query
     * @param  Closure  $next
     * @return Builder<Model>
     */
    public function __invoke(string $columnName, Builder $query, Closure $next): Builder
    {
        $columnExists = Schema::hasColumn(
            table: $query->getModel()->getTable(),
            column: $columnName,
        );

        $filter = $this->getFilter('date');

        if ((! $columnExists) || null === $filter) {
            return $next($query);
        }

        $dates = collect(
            value: explode(',', $filter),
        )->map(
            callback: fn($date) => Carbon::parse($date)->format('Y-m-d H:i'),
        );

        $query
            ->when(
                value: count($dates) === 1,
                callback: function (Builder $query) use ($columnName, $dates): void {
                    $query->whereDate($columnName, '=', $dates[0]);
                },
            )->when(
                value: count($dates) > 1,
                callback: function (Builder $query) use ($columnName, $dates): void {
                    $query->whereBetween($columnName, [$dates[0], $dates[1]]);
                },
            );

        return $next($query);
    }
}
