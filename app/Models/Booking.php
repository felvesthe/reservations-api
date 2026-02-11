<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Booking extends Model
{
    use HasUlids;

    protected $fillable = [
        'user_id',
        'reservable_id',
        'start_at',
        'end_at',
    ];

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(
            related: User::class,
            foreignKey: 'user_id',
        );
    }

    /** @return BelongsTo<Reservable, $this> */
    public function reservable(): BelongsTo
    {
        return $this->belongsTo(
            related: Reservable::class,
            foreignKey: 'reservable_id',
        );
    }

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
