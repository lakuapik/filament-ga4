<?php

namespace Lakuapik\FilamentGA4\Widgets;

use Filament\Widgets\Widget;
use Lakuapik\FilamentGA4\Traits;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\OrderBy;
use Spatie\Analytics\Period;

class TopReferrersListWidget extends Widget
{
    use Traits\CanViewWidget;

    protected static string $view = 'filament-ga4::widgets.top-referrers-list-widget';

    protected static ?int $sort = 3;

    public ?string $filter = 'T';

    public bool $readyToLoad = false;

    public function init(): void
    {
        $this->readyToLoad = true;
    }

    protected function getHeading(): ?string
    {
        return __('filament-ga4::widgets.top_referrers');
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
            ['totalUsers'],
            ['pageReferrer'],
            10,
            [OrderBy::dimension('totalUsers', true)]
        ), collect());

        return $results
            ->map(fn ($row) => [
                'url' => $row['pageReferrer'] ?: '(unknown)',
                'pageViews' => $row['totalUsers'],
            ])
            ->toArray();
    }

    protected function getViewData(): array
    {
        return [
            'filters' => static::filters(),
            'data' => $this->readyToLoad ? $this->getData() : [],
        ];
    }
}
