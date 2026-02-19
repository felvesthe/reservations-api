<?php

declare(strict_types=1);

namespace App\Enums\Auth;

enum PermissionType: string
{
    case BOOKING_ACCESS = 'booking_access';
    case BOOKING_MANAGE_OWN = 'booking_manage_own';
    case BOOKING_MANAGE_ALL = 'booking_manage_all';

    case RESERVABLE_ACCESS = 'reservable_access';
    case RESERVABLE_MANAGE = 'reservable_manage';

    case USER_ACCESS = 'user_access';
    case USER_MANAGE = 'user_manage';
}
