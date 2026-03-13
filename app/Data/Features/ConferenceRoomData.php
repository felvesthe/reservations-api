<?php

declare(strict_types=1);

namespace App\Data\Features;

use App\Data\FeatureData;
use InvalidArgumentException;
use JsonException;

final readonly class ConferenceRoomData implements FeatureData
{
    public function __construct(
        public bool $board,
        public bool $projector,
        public int $seats,
    ) {}

    /**
     * @param array{
     *     board: ?bool,
     *     projector: ?bool,
     *     seats: ?int
     * } $data,
     * @param ?ConferenceRoomData  $currentFeatures
     */
    public static function fromArray(array $data, ?FeatureData $currentFeatures = null): self
    {
        $seats = $data['seats'] ?? $currentFeatures?->seats;

        if (! $seats) {
            throw new InvalidArgumentException(__('exceptions.conference_room.features.seats_required'));
        }

        return new self(
            board: $data['board'] ?? $currentFeatures->board ?? false,
            projector: $data['projector'] ?? $currentFeatures->projector ?? false,
            seats: $seats,
        );
    }

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
