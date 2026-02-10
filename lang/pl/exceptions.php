<?php

declare(strict_types=1);

return [
    'reservable' => [
        'type' => [
            'not_exists' => 'Wprowadzony typ nie istnieje.',
        ],
        'features' => [
            'not_instance_of' => 'Wprowadzona wartość nie jest instancją FeatureData.',
        ],
    ],
];
