<?php

declare(strict_types=1);

namespace App\Actions\Api\V1;

use App\Http\Payloads\V1\CreateBookingPayload;
use App\Http\Requests\V1\Bookings\StoreBookingRequest;
use App\Jobs\CreateBooking;
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

        if (! $this->bookingRepository->isReservableAvailableInPeriod(
            reservableId: $request->string('reservable_id')->toString(),
            startAt: $data['start_at'],
            endAt: $data['end_at'],
        )
        ) {
            throw ValidationException::withMessages(['period' => __('responses.v1.bookings.store.failure_invalid_period')]);
        }

        CreateBooking::dispatch($payload);
    }
}
