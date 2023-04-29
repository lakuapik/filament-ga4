<?php

namespace Lakuapik\FilamentGA4\Traits;

use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\OrderBy;
use Spatie\Analytics\Period;

trait Sessions
{
    use PeriodsTable;

    private function getSessions(
        Period $currentPeriod,
        Period $previousPeriod,
        string $dimension = 'date',
    ): array {
        $currentResults = Analytics::get(
            $currentPeriod,
            ['sessions'],
            [$dimension],
            100,
            [OrderBy::dimension($dimension, true)]
        );

        $previousResults = Analytics::get(
            $previousPeriod,
            ['sessions'],
            [$dimension],
            100,
            [OrderBy::dimension($dimension, true)]
        );

        return [
            'previous' => $previousResults->pluck('sessions')->sum() ?? 0,
            'result' => $currentResults->pluck('sessions')->sum() ?? 0,
        ];
    }

    private function sessionsToday(): array
    {
        $periods = $this->getPeriodsToday();

        return $this->getSessions($periods['current'], $periods['previous'], 'date');
    }

    private function sessionsYesterday(): array
    {
        $periods = $this->getPeriodsYesterday();

        return $this->getSessions($periods['current'], $periods['previous'], 'date');
    }

    private function sessionsLastWeek(): array
    {
        $periods = $this->getPeriodsLastWeek();

        return $this->getSessions($periods['current'], $periods['previous'], 'year');
    }

    private function sessionsLastMonth(): array
    {
        $periods = $this->getPeriodsLastMonth();

        return $this->getSessions($periods['current'], $periods['previous'], 'year');
    }

    private function sessionsLastSevenDays(): array
    {
        $periods = $this->getPeriodsLastSevenDays();

        return $this->getSessions($periods['current'], $periods['previous'], 'year');
    }

    private function sessionsLastThirtyDays(): array
    {
        $periods = $this->getPeriodsLastThirtyDays();

        return $this->getSessions($periods['current'], $periods['previous'], 'year');
    }
}
