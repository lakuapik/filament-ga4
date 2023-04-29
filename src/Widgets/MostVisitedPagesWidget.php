<?php

namespace Lakuapik\FilamentGA4\Widgets;

use Filament\Widgets\Widget;
use Lakuapik\FilamentGA4\Traits;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\OrderBy;
use Spatie\Analytics\Period;

class MostVisitedPagesWidget extends Widget
{
    use Traits\CanViewWidget;

    protected static string $view = 'filament-ga4::widgets.most-visited-pages-widget';

    protected static ?int $sort = 3;

    public ?string $filter = 'T';

    public bool $readyToLoad = false;

    public function init(): void
    {
        $this->readyToLoad = true;
    }

    protected function getHeading(): ?string
    {
        return __('filament-ga4::widgets.most_visited_pages');
    }

    protected static function filters(): array
    {
        return [
            'T' => __('filament-ga4::widgets.T'),
            'TW' => __('filament-ga4::widgets.TW'),
            'TM' => __('filament-ga4::widgets.TM'),
            'TY' => __('filament-ga4::widgets.TY'),
        ];
    }

    protected function getData(): array
    {
        $lookups = [
            'T' => Period::days(1),
            'TW' => Period::days(7),
            'TM' => Period::months(1),
            'TY' => Period::years(1),
        ];

        $results = rescue(fn () => Analytics::get(
            @$lookups[$this->filter] ?? $lookups['T'],
            ['screenPageViews'],
            ['pageTitle', 'hostname', 'pagePath'],
            10,
            [OrderBy::metric('screenPageViews', true)]
        ), collect());

        return $results
            ->map(fn ($row) => [
                'name' => $row['pageTitle'],
                'hostname' => $row['hostname'],
                'path' => $row['pagePath'],
                'visits' => $row['screenPageViews'],
            ])
            ->toArray();
    }

    protected function getViewData(): array
    {
        return [
            'data' => $this->readyToLoad ? $this->getData() : [],
            'filters' => static::filters(),
        ];
    }
}
