<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

final class BookingCreated extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        private readonly Booking $booking,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('mail.booking.success.subject', ['id' => $this->booking->id]),
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.bookings.created',
            with: [
                'userName' => $this->booking->user?->first_name,
                'reservableName' => $this->booking->reservable?->name,
                'startAt' => Carbon::parse($this->booking->start_at)->format('Y-m-d H:i'),
                'endAt' => Carbon::parse($this->booking->end_at)->format('Y-m-d H:i'),
            ],
        );
    }
}
