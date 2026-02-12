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
    public bool $withoutObjectCaching = true;

    /**
     * @param  Reservable  $model
     * @param  string  $key
     * @param  string|null  $value
     * @param  array<string, mixed>  $attributes
     * @return FeatureData|null
     * @throws JsonException
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): ?FeatureData
    {
        if (null === $value) {
            return null;
        }

        /** @var array<string, mixed> $data */
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
     * @throws JsonException
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): string
    {
        /** @var FeatureStrategyContext $strategyService */
        $strategyService = FeatureStrategyFactory::create(
            reservableType: $model->type->value,
            reservable: $model,
        );

        if (is_string($value) && json_validate($value)) {
            /** @var array<string, mixed> $data */
            $data = json_decode(
                json: $value,
                associative: true,
                flags: JSON_THROW_ON_ERROR,
            );

            return $strategyService
                ->make($data)
                ->toJson();
        }

        if (is_array($value)) {
            /** @var array<string, mixed> $value */
            return $strategyService
                ->make($value)
                ->toJson();
        }

        if ($value instanceof FeatureData) {
            return $value->toJson();
        }

        throw new InvalidArgumentException(__('exceptions.reservable.features.not_supported'));
    }
}
