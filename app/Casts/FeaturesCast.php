<?php

declare(strict_types=1);

namespace App\Casts;

use App\Data\FeatureData;
use App\Models\Reservable;
use App\Strategies\FeatureStrategyContext;
use App\Strategies\FeatureStrategyFactory;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use JsonException;

/**
 * @implements CastsAttributes<FeatureData, string>
 */
final class FeaturesCast implements CastsAttributes
{
    /**
     * @param  Reservable  $model
     * @param  string  $value
     * @param  array<string, mixed>  $attributes
     * @throws JsonException
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): FeatureData
    {
        /** @var array<string, bool|int|string> $data */
        $data = json_decode(
            json: $value,
            associative: true,
            flags: JSON_THROW_ON_ERROR,
        );

        /** @var FeatureStrategyContext $strategyService */
        $strategyService = FeatureStrategyFactory::create(
            reservableType: $model->type->value,
        );

        return $strategyService->make($data);
    }

    /**
     * @param  Reservable  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array<string, mixed>  $attributes
     * @return string
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): string
    {
        if (! $value instanceof FeatureData) {
            throw new InvalidArgumentException('The given value is not a FeatureData instance.');
        }

        return $value->toJson();
    }
}
