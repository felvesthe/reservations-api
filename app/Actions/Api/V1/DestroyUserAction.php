<?php

declare(strict_types=1);

namespace App\Actions\Api\V1;

use App\Models\User;

final class DestroyUserAction
{
    public function execute(User $user): void
    {
        $user->delete();
    }
}
