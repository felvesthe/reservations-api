<?php

declare(strict_types=1);

return [
    'hello' => 'Cześć, :name!',
    'booking' => [
        'success' => [
            'subject' => 'Rezerwacja o ID :id utworzona pomyślnie!',
            'created_successfully' => 'Twoja rezerwacja zasobu :reservableName została utworzona pomyślnie.',
            'start_at' => 'Rozpoczyna się: :date',
            'end_at' => 'Kończy się: :date',
        ],
        'reminder' => [
            'subject' => 'Rezerwacja o ID :id rozpoczyna się za :time minut(y)!',
            'body' => 'Przypominamy, że Twoja rezerwacja zasobu :reservable_name rozpoczyna się o godzinie :start_at.',
        ],
    ],
];
