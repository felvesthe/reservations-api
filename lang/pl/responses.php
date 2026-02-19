<?php

declare(strict_types=1);

return [
    'v1' => [
        'bookings' => [
            'store' => [
                'success' => 'Proces tworzenia rezerwacji odbędzie się w tle. Gdy zostanie ukończony, zostaniesz poinformowany poprzez wybrane sposoby komunikacji.',
                'failure_invalid_period' => 'Wybrany zasób jest niedostępny w podanym czasie.',
            ],
            'destroy' => [
                'success' => 'Proces anulowania rezerwacji odbędzie się w tle. Gdy zostanie ukończony, zostaniesz poinformowany poprzez wybrane sposoby komunikacji.',
                'failure_passed' => 'Nie możesz anulować rezerwacji po czasie jej trwania.',
            ],
        ],
    ],
];
