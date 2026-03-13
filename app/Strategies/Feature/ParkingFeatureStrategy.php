<?php

declare(strict_types=1);

namespace App\Strategies\Feature;

use App\Data\FeatureData;
use App\Data\Features\ParkingData;
use App\Models\Reservable;
use App\Strategies\FeatureStrategyInterface;
use InvalidArgumentException;

final readonly class ParkingFeatureStrategy implements FeatureStrategyInterface
{
    private ?ParkingData $currentFeatures;

    public function __construct(
        private ?Reservable $reservable,
    ) {
        /** @var ParkingData|null $currentFeatures */
        $currentFeatures = $this->reservable?->features;

        $this->currentFeatures = $currentFeatures;
    }

    /**
     * @param array{
     *     sector: ?string,
     *     spaces: ?int,
     *     ev_charger: ?bool
     * } $data
     */
    public function make(array $data): FeatureData
    {
        $parkingData = ParkingData::fromArray($data, $this->currentFeatures);

        if ($parkingData->spaces < 1) {
            throw new InvalidArgumentException(__('exceptions.parking.features.spaces_positive_number'));
        }

        return $parkingData;
    }
}
