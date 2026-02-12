<?php

declare(strict_types=1);

namespace App\Strategies\Feature;

use App\Data\FeatureData;
use App\Data\Features\DeskData;
use App\Models\Reservable;
use App\Strategies\FeatureStrategyInterface;
use InvalidArgumentException;

/**
 * @phpstan-type DeskDataArray array{
 *     monitor_size: ?float,
 *     height_adjustment: ?bool
 * }
 */
final readonly class DeskFeatureStrategy implements FeatureStrategyInterface
{
    /** @var DeskData|null $currentFeatures */
    private ?FeatureData $currentFeatures;

    public function __construct(
        private ?Reservable $reservable,
    ) {
        /** @var DeskData|null $currentFeatures */
        $currentFeatures = $this->reservable?->features;

        $this->currentFeatures = $currentFeatures;
    }

    /** @param DeskDataArray $data */
    public function make(array $data): FeatureData
    {
        return new DeskData(
            monitorSize: $this->monitorSize($data),
            heightAdjustment: $this->heightAdjustment($data),
        );
    }

    /** @param DeskDataArray $data */
    private function monitorSize(array $data): float
    {
        $monitorSize = $data['monitor_size'] ?? $this->currentFeatures?->monitorSize;

        if (null === $monitorSize) {
            throw new InvalidArgumentException(__('exceptions.desk.features.monitor_size_required'));
        }

        if ($monitorSize <= 0.0) {
            throw new InvalidArgumentException(__('exceptions.desk.features.monitor_size_greater_than_zero'));
        }

        return $monitorSize;
    }

    /** @param DeskDataArray $data */
    private function heightAdjustment(array $data): bool
    {
        return $data['height_adjustment'] ?? $this->currentFeatures->heightAdjustment ?? false;
    }
}
