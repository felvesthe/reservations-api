<?php

declare(strict_types=1);

namespace App\Pipelines\Filters\Bookings;

use App\Models\Booking;
use App\Pipelines\Filters\Filter;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

final class DateFilter extends Filter
{
    /**
     * @param  Builder<Booking>  $query
     * @param  Closure  $next
     * @return Builder<Booking>
     */
    public function __invoke(Builder $query, Closure $next): Builder
    {
        $filter = $this->getFilter('date');

        if (null === $filter) {
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
                callback: function (Builder $query) use ($dates): void {
                    $query->whereDate('start_at', '=', $dates[0]);
                },
            )->when(
                value: count($dates) > 1,
                callback: function (Builder $query) use ($dates): void {
                    $query->whereBetween('start_at', [$dates[0], $dates[1]]);
                },
            );

        return $next($query);
    }
}
