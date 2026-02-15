<?php

declare(strict_types=1);

namespace App\Actions\Api\V1;

use App\Enums\ReservableType;
use App\Http\Requests\V1\Reservables\StoreReservableRequest;
use App\Models\Reservable;

final class CreateReservableAction
{
    public function execute(StoreReservableRequest $request): void
    {
        Reservable::create([
            'name' => $request->string('name')->toString(),
            'type' => $request->enum('type', ReservableType::class),
            'features' => $request->array('features'),
        ]);
    }
}
