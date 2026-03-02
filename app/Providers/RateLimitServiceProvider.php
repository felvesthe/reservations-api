<?php

declare(strict_types=1);

namespace App\Providers;

use App\Enums\Auth\RoleType;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

final class RateLimitServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        RateLimiter::for(
            name: 'api',
            callback: fn(Request $request): Limit => $request->user()?->hasRole(RoleType::MANAGER->value)
                ? Limit::none()
                : Limit::perMinute(config()->integer('rate-limiter.api_rate_limit_per_minute')),
        );
    }
}
