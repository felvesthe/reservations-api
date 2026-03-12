<?php

use App\Enums\Auth\RoleType;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;

beforeEach(function () {
    $this->seed([PermissionSeeder::class, RoleSeeder::class]);
    $this->employee = User::factory()->create();
});

test('user is assigned to employee role after creation', function () {
    $hasEmployeeRole = $this->employee->hasRole(RoleType::EMPLOYEE->value);

    expect($hasEmployeeRole)
        ->toBeTrue();
});

test('employee can access employees list', function () {
    $this->actingAs($this->employee)
        ->getJson(route('v1:users:index'))
        ->assertOk()
        ->assertJsonStructure(['data' => [
            '*' => [
                'id',
                'first_name',
                'last_name',
                'username',
                'email',
                'notification_channels',
            ]
        ]]);
});

test('employee can access other employee details', function () {
    $otherEmployee = User::factory()->create();

    $this->actingAs($this->employee)
        ->getJson(route('v1:users:show', ['user' => $otherEmployee]))
        ->assertOk()
        ->assertJsonStructure([
            'id',
            'first_name',
            'last_name',
            'username',
            'email',
            'notification_channels' => [
                'email',
                'telegram'
            ]
        ]);
});

test('employee cannot delete his profile', function () {
    $this->actingAs($this->employee)
        ->delete(route('v1:users:destroy', ['user' => $this->employee]))
        ->assertForbidden();

    $this->assertDatabaseHas('users', [
        'id' => $this->employee->id,
    ]);
});

test('manager can delete employee\'s profile', function () {
    $manager = User::factory()->create()->syncRoles(RoleType::MANAGER->value);

    $this->actingAs($manager)
        ->delete(route('v1:users:destroy', ['user' => $this->employee]))
        ->assertNoContent();

    $this->assertSoftDeleted('users', [
        'id' => $this->employee->id,
    ]);
});
