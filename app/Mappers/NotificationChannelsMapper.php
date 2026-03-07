<?php

declare(strict_types=1);

namespace App\Mappers;

use App\Models\User;
use App\Notifications\TelegramChannel;

final class NotificationChannelsMapper
{
    /** @var array<string, mixed> */
    private array $map = [
        'email' => 'mail',
        'telegram' => TelegramChannel::class,
    ];

    /**
     * @param  User  $user
     * @return array<int, mixed>
     */
    public function getNotificationChannels(User $user): array
    {
        /** @var array<string, bool> $userChannels */
        $userChannels = $user->notification_channels;

        if (empty($userChannels)) {
            return [];
        }

        $channels = [];

        foreach ($this->map as $key => $value) {
            if ($userChannels[$key] ?? false) {
                $channels[] = $value;
            }
        }

        return $channels;
    }
}
