<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Reservable;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Booking>
 */
final class BookingFactory extends Factory
{
    /** @var class-string<Booking> */
    protected $model = Booking::class;

    /** @return array<string, mixed> */
    public function definition(): array
    {
        $startAt = $this->faker->dateTime();
        $endAt = Carbon::createFromInterface($startAt)
            ->addHours(rand(1, 5));

        return [
            'user_id' => User::factory(),
            'reservable_id' => Reservable::factory(),
            'start_at' => $startAt,
            'end_at' => $endAt,
        ];
    }
}
