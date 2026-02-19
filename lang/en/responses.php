<?php

declare(strict_types=1);

return [
    'v1' => [
        'bookings' => [
            'store' => [
                'success' => 'Booking creation will be processed in the background. When finished, you will be notified by selected notification channels.',
                'failure_invalid_period' => 'Selected resource is not available in that period.',
            ],
            'destroy' => [
                'success' => 'Booking cancellation will be processed in the background. When finished, you will be notified by selected notification channels.',
                'failure_passed' => 'You cannot cancel booking that passed.',
            ],
        ],
    ],
];
