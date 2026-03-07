<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Services\TelegramServiceInterface;
use Illuminate\Notifications\Notification;

final readonly class TelegramChannel
{
    public function __construct(
        private TelegramServiceInterface $telegramService,
    ) {}

    public function send(object $notifiable, Notification $notification): void
    {
        if (! $notification instanceof TelegramNotificationInterface) {
            return;
        }

        $message = $notification->toTelegram($notifiable);

        $this->telegramService->sendMessage($message);
    }
}
