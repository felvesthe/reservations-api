<?php

declare(strict_types=1);

namespace App\Http\Payloads\V1;

use App\Http\Requests\V1\Bookings\StoreBookingRequest;
use Carbon\CarbonInterface;
use InvalidArgumentException;

final readonly class CreateBookingPayload
{
    public function __construct(
        private StoreBookingRequest $request,
    ) {}

    /**
     * @return array{
     *     user_id: string,
     *     reservable_id: string,
     *     start_at: CarbonInterface,
     *     end_at: CarbonInterface
     * }
     */
    public function toArray(): array
    {
        $startAt = $this->request->date('start_at');
        $endAt = $this->request->date('end_at');

        if (null === $startAt || null === $endAt) {
            throw new InvalidArgumentException('Start at and end at cannot be null');
        }

        return [
            'user_id' => $this->request->string('user_id')->toString(),
            'reservable_id' => $this->request->string('reservable_id')->toString(),
            'start_at' => $startAt,
            'end_at' => $endAt,
        ];
    }
}
