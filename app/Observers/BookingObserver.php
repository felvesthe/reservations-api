<?php

declare(strict_types=1);

namespace App\Observers;

use App\Mail\BookingCreated;
use App\Models\Booking;
use App\Services\TelegramServiceInterface;
use Illuminate\Support\Facades\Mail;

final readonly class BookingObserver
{
    public function __construct(
        private TelegramServiceInterface $telegramService,
    ) {}

    public function created(Booking $booking): void
    {
        /** @var array<string, bool> $notificationChannels */
        $notificationChannels = $booking->user?->notification_channels;

        if ($notificationChannels['telegram']) {
            $this->telegramService->bookingCreated($booking);
        }

        if ($notificationChannels['email']) {
            Mail::to($booking->user)
                ->queue(new BookingCreated($booking));
        }
    }

    public function deleted(Booking $booking): void
    {
        /** @var array<string, bool> $notificationChannels */
        $notificationChannels = $booking->user?->notification_channels;

        if ($notificationChannels['telegram']) {
            $this->telegramService->bookingCancelled($booking);
        }
    }
}
