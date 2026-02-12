<?php

declare(strict_types=1);

namespace App\Data\Features;

use App\Data\FeatureData;
use JsonException;

final readonly class DeskData implements FeatureData
{
    public function __construct(
        public float $monitorSize,
        public bool $heightAdjustment,
    ) {}

    /**
     * @throws JsonException
     */
    public function toJson(): string
    {
        return json_encode(
            value: [
                'monitor_size' => $this->monitorSize,
                'height_adjustment' => $this->heightAdjustment,
            ],
            flags: JSON_THROW_ON_ERROR,
        );
    }
}
