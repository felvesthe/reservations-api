<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Enums\ReservableType;
use App\Models\Booking;
use Carbon\CarbonInterface;
use Illuminate\Support\Collection;

interface BookingRepositoryInterface
{
    public function isReservableAvailableInPeriod(string $reservableId, CarbonInterface $startAt, CarbonInterface $endAt): bool;
    public function countActiveUserBookingsOfType(string $userId, ReservableType $reservableType): int;
    public function hasAnyBookingsOfTypeInPeriod(string $userId, ReservableType $reservableType, CarbonInterface $startAt, CarbonInterface $endAt): bool;

    /**
     * @param  int  $minutes
     * @param  array<int, string>  $includedRelations
     * @return Collection<int, Booking>
     */
    public function getBookingsStartingIn(int $minutes, array $includedRelations = []): Collection;
}
