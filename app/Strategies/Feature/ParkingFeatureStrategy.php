<?php

declare(strict_types=1);

namespace App\Strategies\Feature;

use App\Data\FeatureData;
use App\Data\Features\ParkingData;
use App\Strategies\FeatureStrategyInterface;

final class ParkingFeatureStrategy implements FeatureStrategyInterface
{
    /**
     * @param array{
     *     sector: string,
     *     spaces: int,
     *     ev_charger: bool
     * } $data
     */
    public function make(array $data): FeatureData
    {
        return new ParkingData(
            sector: $data['sector'],
            spaces: $data['spaces'],
            evCharger: $data['ev_charger'],
        );
    }
}
