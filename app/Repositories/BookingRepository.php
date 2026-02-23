<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Enums\ReservableType;
use App\Models\Booking;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Builder;

final class BookingRepository implements BookingRepositoryInterface
{
    public function isReservableAvailableInPeriod(string $reservableId, CarbonInterface $startAt, CarbonInterface $endAt): bool
    {
        $query = Booking::query()
            ->where('reservable_id', $reservableId);

        $this->bookingsInPeriod(
            query: $query,
            startAt: $startAt,
            endAt: $endAt,
        );

        return ! $query->exists();
    }

    public function countActiveUserBookingsOfType(string $userId, ReservableType $reservableType): int
    {
        return $this->activeUserBookingsOfType(
            query: Booking::query(),
            userId: $userId,
            reservableType: $reservableType,
        )->count();
    }

    public function hasAnyBookingsOfTypeInPeriod(string $userId, ReservableType $reservableType, CarbonInterface $startAt, CarbonInterface $endAt): bool
    {
        $query = Booking::query();

        $this->activeUserBookingsOfType(
            query: $query,
            userId: $userId,
            reservableType: $reservableType,
        );

        $this->bookingsInPeriod(
            query: $query,
            startAt: $startAt,
            endAt: $endAt,
        );

        return $query->exists();
    }

    /**
     * @param  Builder<Booking>  $query
     * @param  string  $userId
     * @param  ReservableType  $reservableType
     * @return Builder<Booking>
     */
    private function activeUserBookingsOfType(Builder $query, string $userId, ReservableType $reservableType): Builder
    {
        return $query
            ->where('user_id', $userId)
            ->whereHas('reservable', function (Builder $query) use ($reservableType): void {
                $query->where('type', $reservableType);
            });
    }

    /**
     * @param  Builder<Booking>  $query
     * @param  CarbonInterface  $startAt
     * @param  CarbonInterface  $endAt
     * @return Builder<Booking>
     */
    private function bookingsInPeriod(Builder $query, CarbonInterface $startAt, CarbonInterface $endAt): Builder
    {
        return $query
            ->where(function (Builder $query) use ($startAt, $endAt): void {
                $query->whereBetween('start_at', [$startAt, $endAt->clone()->subMinute()])
                    ->orWhereBetween('end_at', [$startAt->clone()->addMinute(), $endAt]);
            });
    }
}
