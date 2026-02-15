<?php

declare(strict_types=1);

namespace App\Actions\Api\V1;

use App\Models\Reservable;

final class DestroyReservableAction
{
    public function execute(Reservable $reservable): void
    {
        $reservable->delete();
    }
}
