<?php

declare(strict_types=1);

namespace App\Data\Features;

use App\Data\FeatureData;
use InvalidArgumentException;
use JsonException;

final readonly class DeskData implements FeatureData
{
    public function __construct(
        public float $monitorSize,
        public bool $heightAdjustment,
    ) {}

    /**
     * @param array{
     *     monitor_size: ?float,
     *     monitorSize: ?float,
     *     height_adjustment: ?bool,
     *     heightAdjustment: ?bool
     * } $data,
     * @param ?DeskData $currentFeatures
     */
    public static function fromArray(array $data, ?FeatureData $currentFeatures = null): self
    {
        $monitorSize = $data['monitor_size']
            ?? $data['monitorSize']
            ?? $currentFeatures?->monitorSize;

        if (null === $monitorSize) {
            throw new InvalidArgumentException(__('exceptions.desk.features.monitor_size_required'));
        }

        return new self(
            monitorSize: (float) $monitorSize,
            heightAdjustment: $data['height_adjustment']
                ?? $data['heightAdjustment']
                ?? $currentFeatures->heightAdjustment
                ?? false,
        );
    }

    /**
     * @throws JsonException
     */
    public function toJson(): string
    {
        return json_encode(
            value: [
                'monitor_size' => $this->monitorSize,
                'height_adjustment' => $this->heightAdjustment,
            ],
            flags: JSON_THROW_ON_ERROR,
        );
    }
}
