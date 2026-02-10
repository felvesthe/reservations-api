<?php

declare(strict_types=1);

namespace App\Enums;

enum ReservableType: string
{
    case CONFERENCE_ROOM = 'conference_room';
    case DESK = 'desk';
    case PARKING = 'parking';
}
