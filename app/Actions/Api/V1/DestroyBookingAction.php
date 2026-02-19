<?php

declare(strict_types=1);

namespace App\Actions\Api\V1;

use App\Jobs\DestroyBooking;
use App\Models\Booking;
use InvalidArgumentException;

final class DestroyBookingAction
{
    public function execute(Booking $booking): void
    {
        if ($booking->end_at < now()) {
            throw new InvalidArgumentException(__('responses.v1.bookings.destroy.failure_passed'));
        }

        DestroyBooking::dispatch($booking);
    }
}
