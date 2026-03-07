<?php

declare(strict_types=1);

return [
    /**
     * Minimal period of reservation in minutes.
     */
    'minimal_period' => 15,

    /**
     * Max amount of reservations of one reservable type
     */
    'max_bookings' => 3,

    /**
     * How long before reservation's start user should be notified (in minutes).
     */
    'reminder_time' => 15,
];
