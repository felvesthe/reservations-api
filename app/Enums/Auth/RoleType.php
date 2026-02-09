<?php

declare(strict_types=1);

namespace App\Enums\Auth;

enum RoleType: string
{
    case MANAGER = 'manager';
    case EMPLOYEE = 'employee';
}
