<?php

declare(strict_types=1);

namespace App\Http\Requests\V1\Bookings;

use App\Models\Booking;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

final class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        if (! $this->user()) {
            return false;
        }

        return $this->user()->can('create', Booking::class);
    }

    /** @return array<string, ValidationRule|array<mixed>|string> */
    public function rules(): array
    {
        return [
            'user_id' => ['required'],
            'reservable_id' => ['required'],
            'start_at' => ['required', 'date', 'date_format:Y-m-d H:i', 'after_or_equal:now'],
            'end_at' => ['required', 'date', 'date_format:Y-m-d H:i', 'after:start_at'],
        ];
    }
}
