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
        return ! Booking::query()
            ->where('reservable_id', $reservableId)
            ->where(function (Builder $query) use ($startAt, $endAt): void {
                $query->whereBetween('start_at', [$startAt, $endAt->clone()->subMinute()])
                    ->orWhereBetween('end_at', [$startAt->clone()->addMinute(), $endAt]);
            })
            ->exists();
    }

    public function countActiveUserBookingsOfType(string $userId, ReservableType $reservableType): int
    {
        return Booking::query()
            ->where('user_id', $userId)
            ->whereHas('reservable', function (Builder $query) use ($reservableType): void {
                $query->where('type', $reservableType);
            })
            ->count();
    }
}
