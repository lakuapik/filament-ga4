<?php

namespace Lakuapik\FilamentGA4\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Str;
use Lakuapik\FilamentGA4\FilamentGA4;
use Lakuapik\FilamentGA4\Traits;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\OrderBy;

class SessionsByCountryWidget extends Widget
{
    use Traits\PeriodsTable;
    use Traits\CanViewWidget;

    protected static string $view = 'filament-ga4::widgets.sessions-by-country-widget';

    protected static ?int $sort = 3;

    public ?string $total = null;

    public bool $readyToLoad = false;

    public function init(): void
    {
        $this->readyToLoad = true;
    }

    protected function label(): ?string
    {
        return __('filament-ga4::widgets.sessions_by_country');
    }

    protected function getChartData(): array
    {
        $data = Analytics::get(
            $this->getPeriodsLastThirtyDays()['current'],
            ['sessions'],
            ['country'],
            10,
            [OrderBy::metric('sessions', true)],
        );

        $results = [];

        foreach (collect($data) as $row) {
            $results[Str::headline($row['country'])] = $row['sessions'];
        }

        $this->total = FilamentGA4::thousandsFormater($data->sum('sessions'));

        return [
            'labels' => array_keys($results),
            'datasets' => [
                [
                    'label' => 'Country',
                    'data' => array_map('intval', array_values($results)),
                    'backgroundColor' => [
                        '#008FFB', '#00E396', '#feb019',
                        '#ff455f', '#775dd0', '#80effe',
                    ],
                    'cutout' => '75%',
                    'hoverOffset' => 4,
                    'borderColor' => config('filament.dark_mode') ? 'transparent' : '#fff',
                ],
            ],
        ];
    }

    protected function getOptions(): ?array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'left',
                    'align' => 'bottom',
                    'labels' => [
                        'usePointStyle' => true,
                    ],
                ],
            ],
            'maintainAspectRatio' => false,
            'radius' => '70%',
            'borderRadius' => 4,
            'cutout' => 95,
            'scaleBeginAtZero' => true,
        ];
    }

    protected function getData(): array
    {
        return [
            'chartData' => $this->getChartData(),
            'chartOptions' => $this->getOptions(),
            'total' => $this->total,
        ];
    }

    protected function getViewData(): array
    {
        return [
            'data' => $this->readyToLoad ? $this->getData() : [],
        ];
    }
}
