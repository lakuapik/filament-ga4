<?php

namespace Lakuapik\FilamentGA4\Traits;

use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\OrderBy;
use Spatie\Analytics\Period;

trait PageViews
{
    use PeriodsTable;

    private function getPageViews(
        Period $currentPeriod,
        Period $previousPeriod,
        string $dimension = 'date',
    ): array {
        $currentResults = Analytics::get(
            $currentPeriod,
            ['screenPageViews'],
            [$dimension],
            100,
            [OrderBy::dimension($dimension, true)]
        );

        $previousResults = Analytics::get(
            $previousPeriod,
            ['screenPageViews'],
            [$dimension],
            100,
            [OrderBy::dimension($dimension, true)]
        );

        return [
            'previous' => $previousResults->pluck('screenPageViews')->sum() ?? 0,
            'result' => $currentResults->pluck('screenPageViews')->sum() ?? 0,
        ];
    }

    private function pageViewsToday(): array
    {
        $periods = $this->getPeriodsToday();

        return $this->getPageViews($periods['current'], $periods['previous'], 'date');
    }

    private function pageViewsYesterday(): array
    {
        $periods = $this->getPeriodsYesterday();

        return $this->getPageViews($periods['current'], $periods['previous'], 'date');
    }

    private function pageViewsLastWeek(): array
    {
        $periods = $this->getPeriodsLastWeek();

        return $this->getPageViews($periods['current'], $periods['previous'], 'year');
    }

    private function pageViewsLastMonth(): array
    {
        $periods = $this->getPeriodsLastMonth();

        return $this->getPageViews($periods['current'], $periods['previous'], 'year');
    }

    private function pageViewsLastSevenDays(): array
    {
        $periods = $this->getPeriodsLastSevenDays();

        return $this->getPageViews($periods['current'], $periods['previous'], 'year');
    }

    private function pageViewsLastThirtyDays(): array
    {
        $periods = $this->getPeriodsLastThirtyDays();

        return $this->getPageViews($periods['current'], $periods['previous'], 'year');
    }
}
