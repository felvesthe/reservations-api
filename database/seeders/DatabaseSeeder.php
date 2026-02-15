<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

final class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            ReservableSeeder::class,
            BookingSeeder::class,
        ]);
    }
}
