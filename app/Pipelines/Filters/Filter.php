<?php

declare(strict_types=1);

namespace App\Pipelines\Filters;

abstract class Filter
{
    public function getFilter(string $filterName): ?string
    {
        $filter = request()->array('filter');

        return $filter[$filterName] ?? null;
    }
}
