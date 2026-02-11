<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\ReservableType;
use App\Models\Reservable;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Reservable>
 */
final class ReservableFactory extends Factory
{
    /** @var class-string<Reservable> */
    protected $model = Reservable::class;

    /** @var array<int, array<string, ReservableType|array<string, bool|int|string>>> */
    private array $reservables = [
        [
            'type' => ReservableType::CONFERENCE_ROOM,
            'features' => [
                'board' => false,
                'projector' => true,
                'seats' => 4,
            ],
        ],
        [
            'type' => ReservableType::DESK,
            'features' => [
                'monitor_size' => '27"',
                'height_adjustment' => true,
            ],
        ],
        [
            'type' => ReservableType::PARKING,
            'features' => [
                'sector' => 'A',
                'spaces' => 24,
                'ev_charger' => true,
            ],
        ],
    ];

    /** @return array<string, mixed> */
    public function definition(): array
    {
        /** @var array<string, ReservableType|array<string, bool|int|string>> $reservable */
        $reservable = $this->faker->randomElement($this->reservables);

        return [
            'name' => $this->faker->word(),
            'type' => $reservable['type'],
            'features' => json_encode($reservable['features']),
        ];
    }
}
