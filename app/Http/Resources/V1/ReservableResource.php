<?php

declare(strict_types=1);

namespace App\Http\Resources\V1;

use App\Models\Reservable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read Reservable $resource
 */
final class ReservableResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'type' => $this->resource->type,
            'features' => $this->resource->features,
        ];
    }
}
