<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Booking;
use Carbon\CarbonInterface;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;

final readonly class TelegramService implements TelegramServiceInterface
{
    public function __construct(
        private Api $telegram,
    ) {}

    /**
     * @throws TelegramSDKException
     */
    public function bookingCreated(Booking $booking): void
    {
        /** @var CarbonInterface $startAt */
        $startAt = $booking->start_at;

        /** @var CarbonInterface $endAt */
        $endAt = $booking->end_at;

        $this->telegram->sendMessage([
            'chat_id' => config()->string('telegram.channel_id'),
            'text' => __('telegram.booking.created', [
                'full_name' => $booking->user?->full_name,
                'reservable' => $booking->reservable?->name,
                'start_at' => $startAt->format('Y-m-d H:i'),
                'end_at' => $endAt->format('Y-m-d H:i'),
            ]),
        ]);
    }

    /**
     * @throws TelegramSDKException
     */
    public function bookingCancelled(Booking $booking): void
    {
        /** @var CarbonInterface $startAt */
        $startAt = $booking->start_at;

        /** @var CarbonInterface $endAt */
        $endAt = $booking->end_at;

        $this->telegram->sendMessage([
            'chat_id' => config()->string('telegram.channel_id'),
            'text' => __('telegram.booking.destroyed', [
                'full_name' => $booking->user?->full_name,
                'reservable' => $booking->reservable?->name,
                'start_at' => $startAt->format('Y-m-d H:i'),
                'end_at' => $endAt->format('Y-m-d H:i'),
            ]),
        ]);
    }
}
