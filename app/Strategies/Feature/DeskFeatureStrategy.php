<?php

declare(strict_types=1);

namespace App\Strategies\Feature;

use App\Data\FeatureData;
use App\Data\Features\DeskData;
use App\Strategies\FeatureStrategyInterface;

final class DeskFeatureStrategy implements FeatureStrategyInterface
{
    /**
     * @param array{
     *     monitor_size: string,
     *     height_adjustment: bool
     * } $data
     */
    public function make(array $data): FeatureData
    {
        return new DeskData(
            monitorSize: $data['monitor_size'],
            heightAdjustment: $data['height_adjustment'],
        );
    }
}
