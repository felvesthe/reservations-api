<?php

declare(strict_types=1);

namespace App\Http\Requests\V1\Reservables;

use App\Enums\ReservableType;
use App\Models\Reservable;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreReservableRequest extends FormRequest
{
    public function authorize(): bool
    {
        if (! $this->user()) {
            return false;
        }

        return $this->user()->can('create', Reservable::class);
    }

    /** @return array<string, ValidationRule|array<mixed>|string> */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'type' => ['required', Rule::enum(ReservableType::class)],
            'features' => ['required', 'array'],
        ];
    }
}
