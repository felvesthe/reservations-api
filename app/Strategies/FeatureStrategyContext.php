<?php

declare(strict_types=1);

namespace App\Strategies;

use App\Data\FeatureData;

final readonly class FeatureStrategyContext
{
    public function __construct(
        private FeatureStrategyInterface $strategy,
    ) {}

    /** @param array<string, mixed> $data */
    public function make(array $data): FeatureData
    {
        return $this->strategy->make($data);
    }
}
