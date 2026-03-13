<?php

declare(strict_types=1);

namespace App\Strategies\Feature;

use App\Data\FeatureData;
use App\Data\Features\DeskData;
use App\Models\Reservable;
use App\Strategies\FeatureStrategyInterface;
use InvalidArgumentException;

final readonly class DeskFeatureStrategy implements FeatureStrategyInterface
{
    private ?DeskData $currentFeatures;

    public function __construct(
        private ?Reservable $reservable,
    ) {
        /** @var DeskData|null $currentFeatures */
        $currentFeatures = $this->reservable?->features;

        $this->currentFeatures = $currentFeatures;
    }

    /**
     * @param array{
     *     monitor_size: ?float,
     *     monitorSize: ?float,
     *     height_adjustment: ?bool,
     *     heightAdjustment: ?bool
     * } $data
     */
    public function make(array $data): FeatureData
    {
        $deskData = DeskData::fromArray($data, $this->currentFeatures);

        if ($deskData->monitorSize <= 0.0) {
            throw new InvalidArgumentException(__('exceptions.desk.features.monitor_size_greater_than_zero'));
        }

        return $deskData;
    }
}
