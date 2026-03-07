<?php

declare(strict_types=1);

return [
    'hello' => 'Hello, :name!',
    'booking' => [
        'success' => [
            'subject' => 'Booking with ID :id created successfully!',
            'created_successfully' => 'Your booking of :reservableName has been created successfully.',
            'start_at' => 'Starting at: :date',
            'end_at' => 'Ending at: :date',
        ],
        'reminder' => [
            'subject' => 'Booking with ID :id starting in :time minute(s)!',
            'body' => 'We are reminding you, your booking of :reservable_name starting at :start_at.',
        ],
    ],
];
