<?php

declare(strict_types=1);

namespace App\Actions\Api\V1;

use App\Http\Requests\V1\Reservables\UpdateReservableRequest;
use App\Models\Reservable;

final class UpdateReservableAction
{
    public function execute(UpdateReservableRequest $request, Reservable $reservable): void
    {
        $reservable->update([
            'name' => $request->string('name')->toString() ?: $reservable->name,
            'features' => $request->array('features') ?: $reservable->features,
        ]);
    }
}
