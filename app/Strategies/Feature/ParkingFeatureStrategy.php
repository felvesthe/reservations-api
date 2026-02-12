<?php

declare(strict_types=1);

namespace App\Strategies\Feature;

use App\Data\FeatureData;
use App\Data\Features\ParkingData;
use App\Models\Reservable;
use App\Strategies\FeatureStrategyInterface;
use InvalidArgumentException;

/**
 * @phpstan-type ParkingDataArray array{
 *     sector: ?string,
 *     spaces: ?int,
 *     ev_charger: ?bool
 * }
 */
final readonly class ParkingFeatureStrategy implements FeatureStrategyInterface
{
    /** @var ParkingData|null $currentFeatures */
    private ?FeatureData $currentFeatures;

    public function __construct(
        private ?Reservable $reservable,
    ) {
        /** @var ParkingData|null $currentFeatures */
        $currentFeatures = $this->reservable?->features;

        $this->currentFeatures = $currentFeatures;
    }

    /** @param ParkingDataArray $data */
    public function make(array $data): FeatureData
    {
        return new ParkingData(
            sector: $this->sector($data),
            spaces: $this->spaces($data),
            evCharger: $this->evCharger($data),
        );
    }

    /** @param ParkingDataArray $data */
    private function sector(array $data): string
    {
        $sector = $data['sector'] ?? $this->currentFeatures?->sector;

        if (! $sector) {
            throw new InvalidArgumentException(__('exceptions.parking.features.sector_required'));
        }

        return $sector;
    }

    /** @param ParkingDataArray $data */
    private function spaces(array $data): int
    {
        $spaces = $data['spaces'] ?? $this->currentFeatures?->spaces;

        if (! $spaces) {
            throw new InvalidArgumentException(__('exceptions.parking.features.spaces_required'));
        }

        if ($spaces < 1) {
            throw new InvalidArgumentException(__('exceptions.parking.features.spaces_positive_number'));
        }

        return $spaces;
    }

    /** @param ParkingDataArray $data */
    private function evCharger(array $data): bool
    {
        return $data['ev_charger'] ?? $this->currentFeatures->evCharger ?? false;
    }
}
