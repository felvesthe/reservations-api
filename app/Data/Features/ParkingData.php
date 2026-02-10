<?php

declare(strict_types=1);

namespace App\Data\Features;

use App\Data\FeatureData;
use JsonException;

final readonly class ParkingData implements FeatureData
{
    public function __construct(
        public string $sector,
        public int $spaces,
        public bool $evCharger,
    ) {}

    /**
     * @throws JsonException
     */
    public function toJson(): string
    {
        return json_encode(
            value: [
                'sector' => $this->sector,
                'spaces' => $this->spaces,
                'ev_charger' => $this->evCharger,
            ],
            flags: JSON_THROW_ON_ERROR,
        );
    }
}
