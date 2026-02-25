<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Mail\BookingCreated;
use App\Models\Booking;
use App\Models\User;
use App\Repositories\BookingRepositoryInterface;
use Carbon\CarbonInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

final class CreateBooking implements ShouldQueue
{
    use Queueable;

    /**
     * @param  array{
     *     user: User,
     *     reservable_id: string,
     *     start_at: CarbonInterface,
     *     end_at: CarbonInterface,
     * }  $data
     */
    public function __construct(
        private readonly array $data,
    ) {}

    public function handle(BookingRepositoryInterface $bookingRepository): void
    {
        if (! $bookingRepository->isReservableAvailableInPeriod(
            reservableId: $this->data['reservable_id'],
            startAt: $this->data['start_at'],
            endAt: $this->data['end_at'],
        )) {
            $this->fail(
                exception: ValidationException::withMessages([
                    'period' => __('responses.v1.bookings.store.failure_invalid_period'),
                ]),
            );
        }

        /** @var User $user */
        $user = $this->data['user'];

        $booking = Booking::create([
            'user_id' => $user->id,
            'reservable_id' => $this->data['reservable_id'],
            'start_at' => $this->data['start_at'],
            'end_at' => $this->data['end_at'],
        ]);

        Mail::to($user)
            ->queue(new BookingCreated($booking));
    }
}
