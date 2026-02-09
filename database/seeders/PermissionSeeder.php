<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\Auth\PermissionType;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

final class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        foreach (PermissionType::cases() as $permissionType) {
            Permission::create(['name' => $permissionType->value]);
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
