<?php

namespace Lakuapik\FilamentGA4\Traits;

use Carbon\Carbon;
use Spatie\Analytics\Period;

trait PeriodsTable
{
    private function getPeriodsToday(): array
    {
        return [
            'current' => Period::create(
                Carbon::today()->utc(),
                Carbon::today()->utc(),
            ),
            'previous' => Period::create(
                Carbon::yesterday()->utc(),
                Carbon::yesterday()->utc(),
            ),
        ];
    }

    private function getPeriodsYesterday(): array
    {
        return [
            'current' => Period::create(
                Carbon::yesterday()->utc(),
                Carbon::yesterday()->utc(),
            ),
            'previous' => Period::create(
                Carbon::yesterday()->utc()->subDay(),
                Carbon::yesterday()->utc()->subDay(),
            ),
        ];
    }

    private function getPeriodsLastWeek(): array
    {
        return [
            'current' => Period::create(
                Carbon::today()->utc()->subWeek()->startOfWeek(),
                Carbon::today()->utc()->subWeek()->endOfWeek(),
            ),
            'previous' => Period::create(
                Carbon::today()->utc()->subWeeks(2)->startOfWeek(),
                Carbon::today()->utc()->subWeeks(2)->endOfWeek(),
            ),
        ];
    }

    private function getPeriodsLastMonth(): array
    {
        return [
            'current' => Period::create(
                Carbon::today()->utc()->subMonth()->startOfMonth(),
                Carbon::today()->utc()->subMonth()->startOfMonth()->endOfMonth(),
            ),
            'previous' => Period::create(
                Carbon::today()->utc()->subMonths(2)->startOfMonth(),
                Carbon::today()->utc()->subMonths(2)->startOfMonth()->endOfMonth(),
            ),
        ];
    }

    private function getPeriodsLastSevenDays(): array
    {
        return [
            'current' => Period::create(
                Carbon::yesterday()->utc()->subDays(6),
                Carbon::yesterday()->utc(),
            ),
            'previous' => Period::create(
                Carbon::yesterday()->utc()->subDays(13),
                Carbon::yesterday()->utc()->subDays(7),
            ),
        ];
    }

    private function getPeriodsLastThirtyDays(): array
    {
        return [
            'current' => Period::create(
                Carbon::yesterday()->utc()->utc()->subDays(29),
                Carbon::yesterday()->utc(),
            ),
            'previous' => Period::create(
                Carbon::yesterday()->utc()->subDays(59),
                Carbon::yesterday()->utc()->subDays(30),
            ),
        ];
    }
}
