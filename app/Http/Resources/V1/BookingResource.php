<?php

declare(strict_types=1);

namespace App\Http\Resources\V1;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read Booking $resource
 */
final class BookingResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'user_id' => $this->resource->user_id,
            'reservable_id' => $this->resource->reservable_id,
            'start_at' => DateResource::make($this->resource->start_at),
            'end_at' => DateResource::make($this->resource->end_at),
        ];
    }
}
