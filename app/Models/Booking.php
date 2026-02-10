<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

final class Booking extends Model
{
    use HasUlids;

    protected $fillable = [
        'user_id',
        'reservable_id',
        'start_at',
        'end_at',
    ];

    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
            'reservable_id' => 'integer',
            'start_at' => 'datetime',
            'end_at' => 'datetime',
        ];
    }
}
