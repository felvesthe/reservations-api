<?php

declare(strict_types=1);

namespace App\Strategies\Feature;

use App\Data\FeatureData;
use App\Data\Features\ConferenceRoomData;
use App\Models\Reservable;
use App\Strategies\FeatureStrategyInterface;
use InvalidArgumentException;

/**
 * @phpstan-type ConferenceRoomDataArray array{
 *     board: ?bool,
 *     projector: ?bool,
 *     seats: ?int
 * }
 */
final readonly class ConferenceRoomFeatureStrategy implements FeatureStrategyInterface
{
    /** @var ConferenceRoomData|null $currentFeatures */
    private ?FeatureData $currentFeatures;

    /** @param Reservable|null $reservable */
    public function __construct(
        private ?Reservable $reservable,
    ) {
        /** @var ConferenceRoomData|null $currentFeatures */
        $currentFeatures = $this->reservable?->features;

        $this->currentFeatures = $currentFeatures;
    }

    /** @param ConferenceRoomDataArray $data */
    public function make(array $data): FeatureData
    {
        return new ConferenceRoomData(
            board: $this->board($data),
            projector: $this->projector($data),
            seats: $this->seats($data),
        );
    }

    /** @param ConferenceRoomDataArray $data */
    private function seats(array $data): int
    {
        $seats = $data['seats'] ?? $this->currentFeatures?->seats;

        if (! $seats) {
            throw new InvalidArgumentException(__('exceptions.conference_room.features.seats_required'));
        }

        if ($seats < 1) {
            throw new InvalidArgumentException(__('exceptions.conference_room.features.seats_positive_number'));
        }

        return $seats;
    }

    /** @param ConferenceRoomDataArray $data */
    private function board(array $data): bool
    {
        return $data['board'] ?? $this->currentFeatures->board ?? false;
    }

    /** @param ConferenceRoomDataArray $data */
    private function projector(array $data): bool
    {
        return $data['projector'] ?? $this->currentFeatures->projector ?? false;
    }
}
