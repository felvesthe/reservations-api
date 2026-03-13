<?php

declare(strict_types=1);

namespace App\Data;

interface FeatureData
{
    /** @param array<string, mixed> $data */
    public static function fromArray(array $data, ?FeatureData $currentFeatures = null): self;
    public function toJson(): string;
}
