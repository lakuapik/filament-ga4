<?php

namespace Lakuapik\FilamentGA4\Traits;

use Illuminate\Support\Str;

trait CanViewWidget
{
    public static function canView(): bool
    {
        $x = Str::of(static::class)->after('Widgets\\')->before('Widget')->snake();

        $filamentDashboardStatus = config("filament-ga4.{$x}.filament_dashboard");

        $globalStatus = config("filament-ga4.{$x}.global");

        if ($filamentDashboardStatus && request()->routeIs('filament.pages.dashboard')) {
            return true;
        }

        if ($globalStatus
            && config('filament-ga4.dedicated_dashboard')
            && request()->routeIs('filament.pages.filament-ga4-dashboard')) {
            return true;
        }

        if ($globalStatus && ! $filamentDashboardStatus
            && ! request()->routeIs('filament.pages.dashboard')
            && ! request()->routeIs('filament.pages.filament-ga4-dashboard')) {
            return true;
        }

        return false;
    }
}
