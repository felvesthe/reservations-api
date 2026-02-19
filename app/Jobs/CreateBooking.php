<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Http\Payloads\V1\CreateBookingPayload;
use App\Models\Booking;
use App\Repositories\BookingRepositoryInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Validation\ValidationException;

final class CreateBooking implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly CreateBookingPayload $payload,
    ) {}

    public function handle(BookingRepositoryInterface $bookingRepository): void
    {
        $data = $this->payload->toArray();

        if (! $bookingRepository->isReservableAvailableInPeriod(
            reservableId: $data['reservable_id'],
            startAt: $data['start_at'],
            endAt: $data['end_at'],
        )) {
            $this->fail(
                exception: ValidationException::withMessages([
                    'period' => __('responses.v1.bookings.store.failure_invalid_period'),
                ]),
            );
        }

        Booking::create([
            'user_id' => $data['user_id'],
            'reservable_id' => $data['reservable_id'],
            'start_at' => $data['start_at'],
            'end_at' => $data['end_at'],
        ]);
    }
}
