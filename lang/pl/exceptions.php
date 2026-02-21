<?php

declare(strict_types=1);

return [
    'booking' => [
        'minimal_period' => 'Minimalny czas rezerwacji wynosi :period minut(y).',
        'max_bookings' => 'Jeden użytkownik może mieć maksymalnie :limit aktywne rezerwacje jednego typu zasobu w tym samym momencie.',
    ],
    'reservable' => [
        'type' => [
            'not_exists' => 'Wprowadzony typ nie istnieje.',
        ],
        'features' => [
            'not_supported' => 'Wprowadzona wartość nie jest obsługiwana.',
        ],
    ],
    'conference_room' => [
        'features' => [
            'seats_required' => 'Pole ilość siedzeń jest wymagane.',
            'seats_positive_number' => 'Ilość siedzeń musi być liczbą dodatnią.',
        ],
    ],
    'desk' => [
        'features' => [
            'monitor_size_required' => 'Pole przekątna monitora jest wymagane.',
            'monitor_size_greater_than_zero' => 'Wartość przekątnej monitora musi wynosić więcej niż zero.',
        ],
    ],
    'parking' => [
        'features' => [
            'sector_required' => 'Pole sektor jest wymagane.',
            'spaces_required' => 'Pole ilości miejsc jest wymagane.',
            'spaces_positive_number' => 'Ilość miejsc parkingowych musi być liczbą dodatnią.',
        ],
    ],
];
