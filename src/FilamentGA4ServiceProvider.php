<?php

namespace Lakuapik\FilamentGA4;

use Filament\PluginServiceProvider;
use Spatie\LaravelPackageTools\Package;

class FilamentGA4ServiceProvider extends PluginServiceProvider
{
    protected array $pages = [
        Pages\FilamentGA4Dashboard::class,
    ];

    protected array $widgets = [
        Widgets\PageViewsWidget::class,
        Widgets\VisitorsWidget::class,
        Widgets\ActiveUsers1DayWidget::class,
        Widgets\ActiveUsers7DayWidget::class,
        Widgets\ActiveUsers28DayWidget::class,
        Widgets\SessionsWidget::class,
        Widgets\SessionsDurationWidget::class,
        Widgets\SessionsByCountryWidget::class,
        Widgets\SessionsByDeviceWidget::class,
        Widgets\MostVisitedPagesWidget::class,
        Widgets\TopReferrersListWidget::class,
    ];

    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-ga4')
            ->hasConfigFile()
            ->hasViews()
            ->hasTranslations();
    }
}
