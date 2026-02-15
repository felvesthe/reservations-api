<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\Auth\PermissionType;
use App\Models\User;

final class ReservablePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can(PermissionType::RESERVABLE_ACCESS->value);
    }

    public function view(User $user): bool
    {
        return $user->can(PermissionType::RESERVABLE_ACCESS->value);
    }

    public function create(User $user): bool
    {
        return $user->can(PermissionType::RESERVABLE_MANAGE->value);
    }

    public function update(User $user): bool
    {
        return $user->can(PermissionType::RESERVABLE_MANAGE->value);
    }

    public function delete(User $user): bool
    {
        return $user->can(PermissionType::RESERVABLE_MANAGE->value);
    }
}
