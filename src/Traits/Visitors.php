<?php

namespace Lakuapik\FilamentGA4\Traits;

use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\OrderBy;
use Spatie\Analytics\Period;

trait Visitors
{
    use PeriodsTable;

    private function getVisitors(Period $currentPeriod, Period $previousPeriod)
    {
        $currentResults = Analytics::get(
            $currentPeriod,
            ['activeUsers'],
            ['date'],
            100,
            [OrderBy::dimension('date', true)]
        );

        $previousResults = Analytics::get(
            $previousPeriod,
            ['activeUsers'],
            ['date'],
            100,
            [OrderBy::dimension('date', true)]
        );

        return [
            'previous' => $previousResults->pluck('activeUsers')->sum() ?? 0,
            'result' => $currentResults->pluck('activeUsers')->sum() ?? 0,
        ];
    }

    private function VisitorsToday(): array
    {
        $periods = $this->getPeriodsToday();

        return $this->getVisitors($periods['current'], $periods['previous']);
    }

    private function VisitorsYesterday(): array
    {
        $periods = $this->getPeriodsYesterday();

        return $this->getVisitors($periods['current'], $periods['previous']);
    }

    private function VisitorsLastWeek(): array
    {
        $periods = $this->getPeriodsLastWeek();

        return $this->getVisitors($periods['current'], $periods['previous']);
    }

    private function VisitorsLastMonth(): array
    {
        $periods = $this->getPeriodsLastMonth();

        return $this->getVisitors($periods['current'], $periods['previous']);
    }

    private function VisitorsLastSevenDays(): array
    {
        $periods = $this->getPeriodsLastSevenDays();

        return $this->getVisitors($periods['current'], $periods['previous']);
    }

    private function VisitorsLastThirtyDays(): array
    {
        $periods = $this->getPeriodsLastThirtyDays();

        return $this->getVisitors($periods['current'], $periods['previous']);
    }
}
