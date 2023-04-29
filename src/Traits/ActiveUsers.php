<?php

namespace Lakuapik\FilamentGA4\Traits;

use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\OrderBy;
use Spatie\Analytics\Period;

trait ActiveUsers
{
    private function getActiveUsers(string $metric, int $days): array
    {
        $data = Analytics::get(
            Period::days($days),
            [$metric],
            ['date'],
            100,
            [OrderBy::dimension('date', true)]
        );

        $results = [];

        foreach ($data as $row) {
            $results[$row['date']->format('M j')] = $row[$metric];
        }

        return ['results' => $results];
    }
}
