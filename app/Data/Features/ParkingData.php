<?php

declare(strict_types=1);

namespace App\Data\Features;

use App\Data\FeatureData;
use InvalidArgumentException;
use JsonException;

final readonly class ParkingData implements FeatureData
{
    public function __construct(
        public string $sector,
        public int $spaces,
        public bool $evCharger,
    ) {}

    /**
     * @param array{
     *     sector: ?string,
     *     spaces: ?int,
     *     ev_charger: ?bool
     * } $data,
     * @param ?ParkingData  $currentFeatures
     */
    public static function fromArray(array $data, ?FeatureData $currentFeatures = null): self
    {
        $sector = $data['sector'] ?? $currentFeatures?->sector;

        if (! $sector) {
            throw new InvalidArgumentException(__('exceptions.parking.features.sector_required'));
        }

        $spaces = $data['spaces'] ?? $currentFeatures?->spaces;

        if (! $spaces) {
            throw new InvalidArgumentException(__('exceptions.parking.features.spaces_required'));
        }

        return new self(
            sector: $sector,
            spaces: $spaces,
            evCharger: $data['ev_charger'] ?? $currentFeatures->evCharger ?? false,
        );
    }

    /**
     * @throws JsonException
     */
    public function toJson(): string
    {
        return json_encode(
            value: [
                'sector' => $this->sector,
                'spaces' => $this->spaces,
                'ev_charger' => $this->evCharger,
            ],
            flags: JSON_THROW_ON_ERROR,
        );
    }
}
