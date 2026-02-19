<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Booking;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Throwable;

final class DestroyBooking implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly Booking $booking,
    ) {}

    /**
     * @throws Throwable
     */
    public function handle(): void
    {
        DB::transaction(
            callback: function (): void {
                $this->booking->delete();
            },
            attempts: 3,
        );
    }
}
