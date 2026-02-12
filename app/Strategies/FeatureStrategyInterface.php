<?php

declare(strict_types=1);

namespace App\Strategies;

use App\Data\FeatureData;

interface FeatureStrategyInterface
{
    /** @param array<string, mixed> $data */
    public function make(array $data): FeatureData;
}
