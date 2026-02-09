<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\Auth\PermissionType;
use App\Enums\Auth\RoleType;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

final class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::create(['name' => RoleType::MANAGER->value])
            ->givePermissionTo(Permission::all());

        Role::create(['name' => RoleType::EMPLOYEE->value])
            ->givePermissionTo(PermissionType::USER_ACCESS->value)
            ->givePermissionTo(PermissionType::BOOKING_ACCESS->value)
            ->givePermissionTo(PermissionType::BOOKING_MANAGE->value)
            ->givePermissionTo(PermissionType::RESOURCE_ACCESS->value);

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
