<?php

namespace Lakuapik\FilamentGA4\Widgets;

use Filament\Widgets\Widget;
use Lakuapik\FilamentGA4\FilamentGA4;
use Lakuapik\FilamentGA4\Traits;

class VisitorsWidget extends Widget
{
    use Traits\Visitors;
    use Traits\CanViewWidget;

    protected static string $view = 'filament-ga4::widgets.visitors-widget';

    protected static ?int $sort = 3;

    public ?string $filter = 'T';

    public $readyToLoad = false;

    public function init(): void
    {
        $this->readyToLoad = true;
    }

    public function label(): ?string
    {
        return __('filament-ga4::widgets.visitors');
    }

    protected static function filters(): array
    {
        return [
            'T' => __('filament-ga4::widgets.T'),
            'Y' => __('filament-ga4::widgets.Y'),
            'LW' => __('filament-ga4::widgets.LW'),
            'LM' => __('filament-ga4::widgets.LM'),
            'LSD' => __('filament-ga4::widgets.LSD'),
            'LTD' => __('filament-ga4::widgets.LTD'),
        ];
    }

    protected function initializeData(): FilamentGA4
    {
        $lookups = [
            'T' => fn () => $this->visitorsToday(),
            'Y' => fn () => $this->visitorsYesterday(),
            'LW' => fn () => $this->visitorsLastWeek(),
            'LM' => fn () => $this->visitorsLastMonth(),
            'LSD' => fn () => $this->visitorsLastSevenDays(),
            'LTD' => fn () => $this->visitorsLastThirtyDays(),
        ];

        $data = rescue($lookups[$this->filter], ['result' => 0, 'previous' => 0]);

        return FilamentGA4::for($data['result'])
                     ->previous($data['previous'])
                     ->format('%');
    }

    protected function getData(): array
    {
        $data = $this->initializeData();

        return [
            'label' => $this->label(),
            'value' => $data->trajectoryValue(),
            'icon' => $data->trajectoryIcon(),
            'color' => $data->trajectoryColor(),
            'description' => $data->trajectoryDescription(),
            'chart' => '',
            'chartColor' => '',
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
