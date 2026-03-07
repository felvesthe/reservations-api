<?php

declare(strict_types=1);

namespace App\Schedules;

use App\Models\Booking;
use App\Models\User;
use App\Notifications\BookingRemind;
use App\Repositories\BookingRepositoryInterface;
use App\Services\TelegramServiceInterface;

final class BookingReminder
{
    public function __invoke(BookingRepositoryInterface $bookingRepository, TelegramServiceInterface $telegramService): void
    {
        $bookings = $bookingRepository
            ->getBookingsStartingIn(
                minutes: config()->integer('booking.reminder_time'),
                includedRelations: ['user'],
            );

        if ($bookings->isEmpty()) {
            return;
        }

        $bookings->each(function (Booking $booking): void {
            /** @var User $user */
            $user = $booking->user;

            $user->notify(new BookingRemind($booking));
        });
    }
}
