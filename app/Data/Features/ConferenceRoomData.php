<?php

declare(strict_types=1);

namespace App\Data\Features;

use App\Data\FeatureData;
use JsonException;

final readonly class ConferenceRoomData implements FeatureData
{
    public function __construct(
        public bool $board,
        public bool $projector,
        public int $seats,
    ) {}

    /**
     * @throws JsonException
     */
    public function toJson(): string
    {
        return json_encode(
            value: [
                'board' => $this->board,
                'projector' => $this->projector,
                'seats' => $this->seats,
            ],
            flags: JSON_THROW_ON_ERROR,
        );
    }
}
