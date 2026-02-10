<?php

declare(strict_types=1);

namespace App\Strategies;

use App\Data\FeatureData;

interface FeatureStrategyInterface
{
    /** @param array<string, bool|int|string> $data */
    public function make(array $data): FeatureData;
}
