<?php

namespace Lakuapik\FilamentGA4\Traits;

use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\OrderBy;
use Spatie\Analytics\Period;

trait SessionsDuration
{
    use PeriodsTable;

    private function getSessionsDuration(
        Period $currentPeriod,
        Period $previousPeriod,
        string $dimension = 'date',
    ): array {
        $currentResults = Analytics::get(
            $currentPeriod,
            ['averageSessionDuration'],
            [$dimension],
            100,
            [OrderBy::dimension($dimension, true)]
        );

        $previousResults = Analytics::get(
            $previousPeriod,
            ['averageSessionDuration'],
            [$dimension],
            100,
            [OrderBy::dimension($dimension, true)]
        );

        return [
            'previous' => $previousResults->pluck('averageSessionDuration')->sum() ?? 0,
            'result' => $currentResults->pluck('averageSessionDuration')->sum() ?? 0,
        ];
    }

    private function sessionsDurationToday(): array
    {
        $periods = $this->getPeriodsToday();

        return $this->getSessionsDuration($periods['current'], $periods['previous'], 'date');
    }

    private function sessionsDurationYesterday(): array
    {
        $periods = $this->getPeriodsYesterday();

        return $this->getSessionsDuration($periods['current'], $periods['previous'], 'date');
    }

    private function sessionsDurationLastWeek(): array
    {
        $periods = $this->getPeriodsLastWeek();

        return $this->getSessionsDuration($periods['current'], $periods['previous'], 'year');
    }

    private function sessionsDurationLastMonth(): array
    {
        $periods = $this->getPeriodsLastMonth();

        return $this->getSessionsDuration($periods['current'], $periods['previous'], 'year');
    }

    private function sessionsDurationLastSevenDays(): array
    {
        $periods = $this->getPeriodsLastSevenDays();

        return $this->getSessionsDuration($periods['current'], $periods['previous'], 'year');
    }

    private function sessionsDurationLastThirtyDays(): array
    {
        $periods = $this->getPeriodsLastThirtyDays();

        return $this->getSessionsDuration($periods['current'], $periods['previous'], 'year');
    }
}
