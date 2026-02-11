<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Booking;
use Illuminate\Database\Seeder;

final class BookingSeeder extends Seeder
{
    public function run(): void
    {
        Booking::factory()->count(10)->create();
    }
}
