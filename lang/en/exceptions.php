<?php

declare(strict_types=1);

return [
    'reservable' => [
        'type' => [
            'not_exists' => 'Provided type does not exist.',
        ],
        'features' => [
            'not_instance_of' => 'The given value is not a FeatureData instance.',
        ],
    ],
];
