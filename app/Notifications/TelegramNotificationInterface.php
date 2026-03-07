<?php

declare(strict_types=1);

namespace App\Notifications;

interface TelegramNotificationInterface
{
    public function toTelegram(object $notifiable): string;
}
