<?php

declare(strict_types=1);

namespace App\Strategies;

use App\Enums\ReservableType;
use App\Models\Reservable;
use App\Strategies\Feature\ConferenceRoomFeatureStrategy;
use App\Strategies\Feature\DeskFeatureStrategy;
use App\Strategies\Feature\ParkingFeatureStrategy;
use InvalidArgumentException;

final readonly class FeatureStrategyFactory
{
    public static function create(string $reservableType, ?Reservable $reservable = null): FeatureStrategyContext
    {
        return match ($reservableType) {
            ReservableType::CONFERENCE_ROOM->value => new FeatureStrategyContext(
                new ConferenceRoomFeatureStrategy($reservable),
            ),
            ReservableType::DESK->value => new FeatureStrategyContext(
                new DeskFeatureStrategy($reservable),
            ),
            ReservableType::PARKING->value => new FeatureStrategyContext(
                new ParkingFeatureStrategy($reservable),
            ),
            default => throw new InvalidArgumentException(__('exceptions.reservable.type.not_exists')),
        };
    }
}
