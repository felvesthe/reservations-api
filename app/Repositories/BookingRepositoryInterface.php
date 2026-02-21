<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Enums\ReservableType;
use Carbon\CarbonInterface;

interface BookingRepositoryInterface
{
    public function isReservableAvailableInPeriod(string $reservableId, CarbonInterface $startAt, CarbonInterface $endAt): bool;
    public function countActiveUserBookingsOfType(string $userId, ReservableType $reservableType): int;
}
