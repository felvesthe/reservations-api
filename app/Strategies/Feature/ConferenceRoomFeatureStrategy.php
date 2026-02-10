<?php

declare(strict_types=1);

namespace App\Strategies\Feature;

use App\Data\FeatureData;
use App\Data\Features\ConferenceRoomData;
use App\Strategies\FeatureStrategyInterface;

final class ConferenceRoomFeatureStrategy implements FeatureStrategyInterface
{
    /**
     * @param array{
     *     board: bool,
     *     projector: bool,
     *     seats: int
     * } $data
     */
    public function make(array $data): FeatureData
    {
        return new ConferenceRoomData(
            board: $data['board'],
            projector: $data['projector'],
            seats: $data['seats'],
        );
    }
}
