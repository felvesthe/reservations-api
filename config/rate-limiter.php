<?php

declare(strict_types=1);

return [
    /**
     * Rate limit per minute for API
     */
    'api_rate_limit_per_minute' => env('API_RATE_LIMIT_PER_MINUTE', 60),
];
