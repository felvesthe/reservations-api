<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Booking;
use App\Services\TelegramServiceInterface;

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
