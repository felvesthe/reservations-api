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

    /** @var array<int, array<string, bool|int|string>> */
    private array $features = [
        [
            'board' => false,
            'projector' => true,
            'seats' => 4,
        ],
        [
            'monitor_size' => '27"',
            'height_adjustment' => true,
        ],
        [
            'sector' => 'A',
            'spaces' => 24,
            'ev_charger' => true,
        ],
    ];

    /** @return array<string, mixed> */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'type' => $this->faker->randomElement(ReservableType::cases()),
            'features' => json_encode($this->faker->randomElement($this->features)),
        ];
    }
}
