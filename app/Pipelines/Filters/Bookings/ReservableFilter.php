<?php

declare(strict_types=1);

namespace App\Pipelines\Filters\Bookings;

use App\Models\Booking;
use App\Pipelines\Filters\Filter;
use Closure;
use Illuminate\Database\Eloquent\Builder;

final class ReservableFilter extends Filter
{
    /**
     * @param  Builder<Booking>  $query
     * @param  Closure $next
     * @return Builder<Booking>
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
