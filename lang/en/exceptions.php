<?php

declare(strict_types=1);

return [
    'booking' => [
        'minimal_period' => 'Minimal period of reservation is :period minute(s).',
        'max_bookings' => 'One user can have max. :limit active reservations of one type of resource at once.',
        'one_resource_at_time' => 'You can reserve only one resource of the same type at the same time.',
    ],
    'reservable' => [
        'type' => [
            'not_exists' => 'Provided type does not exist.',
        ],
        'features' => [
            'not_supported' => 'The given value is not supported.',
        ],
    ],
    'conference_room' => [
        'features' => [
            'seats_required' => 'Seats field is required.',
            'seats_positive_number' => 'Number of seats must be positive.',
        ],
    ],
    'desk' => [
        'features' => [
            'monitor_size_required' => 'Monitor size field is required.',
            'monitor_size_greater_than_zero' => 'Monitor size value must be greater than zero.',
        ],
    ],
    'parking' => [
        'features' => [
            'sector_required' => 'Sector field is required.',
            'spaces_required' => 'Spaces field is required.',
            'spaces_positive_number' => 'Number of parking spaces must be positive.',
        ],
    ],
];
