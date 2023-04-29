<?php

namespace Lakuapik\FilamentGA4\Widgets;

use Filament\Widgets\Widget;
use Lakuapik\FilamentGA4\FilamentGA4;
use Lakuapik\FilamentGA4\Traits;

class ActiveUsers1DayWidget extends Widget
{
    use Traits\ActiveUsers;
    use Traits\CanViewWidget;

    protected static string $view = 'filament-ga4::widgets.active-users-1-day-widget';

    protected static ?int $sort = 3;

    public ?string $filter = '5';

    public $readyToLoad = false;

    public function init(): void
    {
        $this->readyToLoad = true;
    }

    public function label(): ?string
    {
        return __('filament-ga4::widgets.1_day_active_users');
    }

    protected static function filters(): array
    {
        return [
            '5' => __('filament-ga4::widgets.FD'),
            '10' => __('filament-ga4::widgets.TD'),
            '15' => __('filament-ga4::widgets.FFD'),
        ];
    }

    public function updatedFilter(): void
    {
        $this->emitSelf('filterChartData', [
            'data' => array_values($this->initializeData()['results']),
        ]);
    }

    protected function initializeData(): array
    {
        $lookups = [
            '5' => fn () => $this->getActiveUsers('active1DayUsers', 5),
            '10' => fn () => $this->getActiveUsers('active1DayUsers', 10),
            '15' => fn () => $this->getActiveUsers('active1DayUsers', 15),
        ];

        return rescue($lookups[$this->filter], ['results' => [0]]);
    }

    protected function getData(): array
    {
        $data = $this->initializeData();

        return [
            'value' => FilamentGA4::for(last($data['results']))->trajectoryValue(),
            'color' => 'primary',
            'chart' => array_values($data['results']),
        ];
    }

    protected function getViewData(): array
    {
        return [
            'filters' => static::filters(),
            'data' => $this->readyToLoad ? $this->getData() : [],
        ];
    }
}
