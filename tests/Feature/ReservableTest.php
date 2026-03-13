<?php

declare(strict_types=1);

use App\Enums\Auth\RoleType;
use App\Models\Reservable;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;

beforeEach(function (): void {
    $this->seed([PermissionSeeder::class, RoleSeeder::class]);
    $this->employee = User::factory()->create();
    $this->manager = User::factory()->create()->syncRoles(RoleType::MANAGER->value);
});

test('employee cannot create reservable', function (): void {
    $reservable = Reservable::factory()->make();

    $this->actingAs($this->employee)
        ->postJson(route('v1:reservables:store'), $reservable->toArray())
        ->assertForbidden();

    $this->assertDatabaseMissing('reservables', [
        'name' => $reservable->name,
        'type' => $reservable->type,
    ]);
});

test('manager can create reservable', function (): void {
    $reservable = Reservable::factory()->make();

    $this->actingAs($this->manager)
        ->postJson(route('v1:reservables:store'), $reservable->toArray())
        ->assertNoContent();

    $this->assertDatabaseHas('reservables', [
        'name' => $reservable->name,
        'type' => $reservable->type,
    ]);
});

test('employee cannot update reservable', function (): void {
    $reservable = Reservable::factory()->create();

    $this->actingAs($this->employee)
        ->patchJson(route('v1:reservables:update', ['reservable' => $reservable]), [
            'name' => 'Test',
        ])->assertForbidden();

    $this->assertDatabaseMissing('reservables', [
        'id' => $reservable->id,
        'name' => 'Test',
    ]);
});

test('manager can update reservable', function (): void {
    $reservable = Reservable::factory()->create();

    $this->actingAs($this->manager)
        ->patchJson(route('v1:reservables:update', ['reservable' => $reservable]), [
            'name' => 'Test',
        ])->assertNoContent();

    $this->assertDatabaseHas('reservables', [
        'id' => $reservable->id,
        'name' => 'Test',
    ]);
});

test('employee cannot delete reservable', function (): void {
    $reservable = Reservable::factory()->create();

    $this->actingAs($this->employee)
        ->deleteJson(route('v1:reservables:destroy', ['reservable' => $reservable]))
        ->assertForbidden();

    $this->assertDatabaseHas('reservables', [
        'id' => $reservable->id,
    ]);
});

test('manager can delete reservable', function (): void {
    $reservable = Reservable::factory()->create();

    $this->actingAs($this->manager)
        ->deleteJson(route('v1:reservables:destroy', ['reservable' => $reservable]))
        ->assertNoContent();

    $this->assertDatabaseMissing('reservables', [
        'id' => $reservable->id,
    ]);
});

test('user can access reservable\'s details', function (string $role) {
    $reservable = Reservable::factory()->create();

    $this->actingAs($this->$role)
        ->getJson(route('v1:reservables:show', ['reservable' => $reservable]))
        ->assertOk()
        ->assertJsonStructure([
            'id',
            'name',
            'type',
            'features',
        ]);
})->with([
    'as employee' => 'employee',
    'as manager' => 'manager',
]);

test('user can access reservables', function (string $role) {
    Reservable::factory()->count(5)->create();

    $this->actingAs($this->$role)
        ->getJson(route('v1:reservables:index'))
        ->assertOk()
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'type',
                    'features',
                ]
            ]
        ]);
})->with([
    'as employee' => 'employee',
    'as manager' => 'manager',
]);
