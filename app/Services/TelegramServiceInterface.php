<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Booking;

interface TelegramServiceInterface
{
    public function bookingCreated(Booking $booking): void;
    public function bookingCancelled(Booking $booking): void;
}
