<?php

declare(strict_types=1);

namespace App\Actions\Api\V1;

use App\Http\Payloads\V1\CreateBookingPayload;
use App\Http\Requests\V1\Bookings\StoreBookingRequest;
use App\Jobs\CreateBooking;
use App\Models\Reservable;
use App\Repositories\BookingRepositoryInterface;
use Illuminate\Validation\ValidationException;

final readonly class CreateBookingAction
{
    public function __construct(
        private BookingRepositoryInterface $bookingRepository,
    ) {}

    public function execute(StoreBookingRequest $request): void
    {
        $payload = new CreateBookingPayload($request);
        $data = $payload->toArray();

        $reservable = Reservable::findOrFail($data['reservable_id']);

        $startAt = $data['start_at'];
        $endAt = $data['end_at'];

        $minimalPeriod = config()->integer('booking.minimal_period');
        $maxBookings = config()->integer('booking.max_bookings');

        if ($this->bookingRepository->countActiveUserBookingsOfType($data['user_id'], $reservable->type) >= $maxBookings) {
            throw ValidationException::withMessages(['bookings_limit' => __('exceptions.booking.max_bookings', ['limit' => $maxBookings])]);
        }

        if ($startAt->diffInMinutes($endAt) < $minimalPeriod) {
            throw ValidationException::withMessages(['period' => __('exceptions.booking.minimal_period', ['period' => $minimalPeriod])]);
        }

        if (! $this->bookingRepository->isReservableAvailableInPeriod(
            reservableId: $data['reservable_id'],
            startAt: $startAt,
            endAt: $endAt,
        )
        ) {
            throw ValidationException::withMessages(['period' => __('responses.v1.bookings.store.failure_invalid_period')]);
        }

        CreateBooking::dispatch($data);
    }
}
