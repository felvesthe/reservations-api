<?php

declare(strict_types=1);

namespace App\Strategies\Feature;

use App\Data\FeatureData;
use App\Data\Features\ConferenceRoomData;
use App\Models\Reservable;
use App\Strategies\FeatureStrategyInterface;
use InvalidArgumentException;

final readonly class ConferenceRoomFeatureStrategy implements FeatureStrategyInterface
{
    private ?ConferenceRoomData $currentFeatures;

    /** @param Reservable|null $reservable */
    public function __construct(
        private ?Reservable $reservable,
    ) {
        /** @var ConferenceRoomData|null $currentFeatures */
        $currentFeatures = $this->reservable?->features;

        $this->currentFeatures = $currentFeatures;
    }

    /**
     * @param array{
     *     board: ?bool,
     *     projector: ?bool,
     *     seats: ?int
     * } $data
     */
    public function make(array $data): FeatureData
    {
        $conferenceRoomData = ConferenceRoomData::fromArray($data, $this->currentFeatures);

        if ($conferenceRoomData->seats < 1) {
            throw new InvalidArgumentException(__('exceptions.conference_room.features.seats_positive_number'));
        }

        return $conferenceRoomData;
    }
}
