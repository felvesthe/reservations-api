<?php

declare(strict_types=1);

namespace App\Http\Resources\V1;

use App\Models\Booking;
use App\Models\Reservable;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read Booking $resource
 */
final class DetailedBookingResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        $user = User::findOrFail($this->resource->user_id);
        $reservable = Reservable::findOrFail($this->resource->reservable_id);

        return [
            'id' => $this->resource->id,
            'user' => UserResource::make($user),
            'reservable' => ReservableResource::make($reservable),
            'start_at' => DateResource::make($this->resource->start_at),
            'end_at' => DateResource::make($this->resource->end_at),
        ];
    }
}
