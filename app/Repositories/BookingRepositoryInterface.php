<?php

declare(strict_types=1);

namespace App\Repositories;

use Carbon\CarbonInterface;

interface BookingRepositoryInterface
{
    public function isReservableAvailableInPeriod(string $reservableId, CarbonInterface $startAt, CarbonInterface $endAt): bool;
}
