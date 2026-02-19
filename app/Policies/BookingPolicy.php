<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\Auth\PermissionType;
use App\Models\Booking;
use App\Models\User;

final class BookingPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can(PermissionType::BOOKING_ACCESS->value);
    }

    public function view(User $user): bool
    {
        return $user->can(PermissionType::BOOKING_ACCESS->value);
    }

    public function create(User $user): bool
    {
        return $user->can(PermissionType::BOOKING_MANAGE_OWN->value)
            || $user->can(PermissionType::BOOKING_MANAGE_ALL->value);
    }

    public function update(User $user, Booking $booking): bool
    {
        return ($user->id === $booking->user_id
            && $user->can(PermissionType::BOOKING_MANAGE_OWN->value))
            || $user->can(PermissionType::BOOKING_MANAGE_ALL->value);
    }

    public function delete(User $user, Booking $booking): bool
    {
        return ($user->id === $booking->user_id
            && $user->can(PermissionType::BOOKING_MANAGE_OWN->value))
            || $user->can(PermissionType::BOOKING_MANAGE_ALL->value);
    }
}
