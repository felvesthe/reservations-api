<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\Auth\PermissionType;
use App\Models\User;

final class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can(PermissionType::USER_ACCESS->value);
    }

    public function view(User $user): bool
    {
        return $user->can(PermissionType::USER_ACCESS->value);
    }

    public function delete(User $user, User $model): bool
    {
        return $model->deleted_at === null
            && $user->can(PermissionType::USER_MANAGE->value);
    }

    public function restore(User $user, User $model): bool
    {
        return $model->deleted_at !== null
            && $user->can(PermissionType::USER_MANAGE->value);
    }

    public function forceDelete(User $user, User $model): bool
    {
        return $model->deleted_at === null
            && $user->can(PermissionType::USER_MANAGE->value);
    }
}
