<?php

declare(strict_types=1);

namespace App\Models;

use App\Casts\FeaturesCast;
use App\Enums\ReservableType;
use Database\Factories\ReservableFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property-read string $name,
 * @property-read ReservableType $type,
 * @property-read array<string, bool|int|string> $features
 */
final class Reservable extends Model
{
    /** @use HasFactory<ReservableFactory>  */
    use HasFactory;
    use HasUlids;

    protected $fillable = [
        'name',
        'type',
        'features',
    ];

    /** @return HasMany<Booking, $this> */
    public function bookings(): HasMany
    {
        return $this->hasMany(
            related: Booking::class,
            foreignKey: 'reservable_id',
        );
    }

    public function casts(): array
    {
        return [
            'type' => ReservableType::class,
            'features' => FeaturesCast::class,
        ];
    }
}
