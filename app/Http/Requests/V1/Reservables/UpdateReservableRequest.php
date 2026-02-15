<?php

declare(strict_types=1);

namespace App\Http\Requests\V1\Reservables;

use App\Models\Reservable;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read Reservable $reservable
 */
final class UpdateReservableRequest extends FormRequest
{
    public function authorize(): bool
    {
        if (! $this->user()) {
            return false;
        }

        return $this->user()->can('update', $this->reservable);
    }

    /** @return array<string, ValidationRule|array<mixed>|string> */
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'min:3', 'max:255'],
            'features' => ['sometimes', 'array'],
        ];
    }
}
