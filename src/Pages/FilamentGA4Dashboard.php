<?php

namespace Lakuapik\FilamentGA4\Pages;

use Filament\Pages\Page;
use Lakuapik\FilamentGA4\Widgets;

class FilamentGA4Dashboard extends Page
{
    protected static string $view = 'filament-ga4::pages.ga4-dashboard';

    public function mount()
    {
        if (! static::canView()) {
            return redirect(config('filament.path'));
        }
    }

    protected static function getNavigationIcon(): string
    {
        return config('filament-ga4.dashboard_icon') ?? 'heroicon-o-chart-bar';
    }

    protected static function getNavigationLabel(): string
    {
        return __('filament-ga4::widgets.navigation_label');
    }

    protected function getTitle(): string
    {
        return __('filament-ga4::widgets.title');
    }

    public static function canView(): bool
    {
        return config('filament-ga4.dedicated_dashboard');
    }

    protected static function shouldRegisterNavigation(): bool
    {
        return static::canView() && static::$shouldRegisterNavigation;
    }

    protected function getHeaderWidgets(): array
    {
        return [
            Widgets\PageViewsWidget::class,
            Widgets\VisitorsWidget::class,
            Widgets\ActiveUsers1DayWidget::class,
            Widgets\ActiveUsers7DayWidget::class,
            // Widgets\ActiveUsers28DayWidget::class,
            Widgets\SessionsWidget::class,
            Widgets\SessionsDurationWidget::class,
            Widgets\SessionsByCountryWidget::class,
            Widgets\SessionsByDeviceWidget::class,
            Widgets\MostVisitedPagesWidget::class,
            Widgets\TopReferrersListWidget::class,
        ];
    }
}
