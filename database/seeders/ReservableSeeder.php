<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Reservable;
use Illuminate\Database\Seeder;

final class ReservableSeeder extends Seeder
{
    public function run(): void
    {
        Reservable::factory()->count(10)->create();
    }
}
