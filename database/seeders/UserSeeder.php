<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\Auth\RoleType;
use App\Models\User;
use Illuminate\Database\Seeder;

final class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->count(10)->create();

        User::factory()->create([
            'email' => 'test@localhost',
            'password' => 'password',
        ]);

        User::factory()->create([
            'email' => 'manager@localhost',
            'password' => 'password',
        ])->assignRole(RoleType::MANAGER->value);
    }
}
