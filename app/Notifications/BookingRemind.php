<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

final class BookingRemind extends Notification implements TelegramNotificationInterface
{
    use Queueable;

    public function __construct(
        private readonly Booking $booking,
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', TelegramChannel::class];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $this->booking->loadMissing('reservable');

        $reservable = $this->booking->reservable->name ?? __('Unknown');
        $reminderMinutes = config()->integer('booking.reminder_time');

        return new MailMessage()
            ->subject(__('mail.booking.reminder.subject', ['id' => $this->booking->id, 'time' => $reminderMinutes]))
            ->line(__('mail.booking.reminder.body', ['reservable_name' => $reservable, 'start_at' => $this->booking->start_at]));
    }

    public function toTelegram(object $notifiable): string
    {
        $this->booking->loadMissing('reservable');

        $reservable = $this->booking->reservable->name ?? __('Unknown');
        $reminderMinutes = config()->integer('booking.reminder_time');

        if ($notifiable instanceof User) {
            return __('reminder.booking.known_user', [
                'full_name' => $notifiable->full_name,
                'reservable_name' => $reservable,
                'time' => $reminderMinutes,
            ]);
        }

        return __('reminder.booking.unknown_user', ['reservable_name' => $reservable, 'time' => $reminderMinutes]);
    }
}
