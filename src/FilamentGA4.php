<?php

namespace Lakuapik\FilamentGA4;

use Illuminate\Support\Carbon;

class FilamentGA4
{
    public string $previous;

    public string $format;

    public function __construct(public ?string $value = null)
    {
        //
    }

    public static function for(?string $value = null): static
    {
        return new static($value);
    }

    public function previous(string $previous): static
    {
        $this->previous = $previous;

        return $this;
    }

    public function format(string $format): static
    {
        $this->format = $format;

        return $this;
    }

    public function compute(): int
    {
        if ($this->value == 0 || $this->previous == 0 || $this->previous == null) {
            return 0;
        }

        return (($this->value - $this->previous) / $this->previous) * 100;
    }

    public function trajectoryValue(): string
    {
        return static::thousandsFormater($this->value);
    }

    public function trajectoryValueAsTimeString(): string
    {
        return Carbon::today()->addSeconds($this->value)->toTimeString();
    }

    public function trajectoryLabel(): string
    {
        return match (gmp_sign($this->compute())) {
            -1 => __('filament-ga4::widgets.trending_down'),
            0 => __('filament-ga4::widgets.steady'),
            1 => __('filament-ga4::widgets.trending_up'),
            default => __('filament-ga4::widgets.steady')
        };
    }

    public function trajectoryColor(): string
    {
        return match (gmp_sign($this->compute())) {
            -1 => config('filament-ga4.trending_down_color'),
            0 => config('filament-ga4.steady_color'),
            1 => config('filament-ga4.trending_up_color'),
            default => config('filament-ga4.steady_color'),
        };
    }

    public function trajectoryIcon(): string
    {
        return match (gmp_sign($this->compute())) {
            1 => config('filament-ga4.trending_up_icon'),
            -1 => config('filament-ga4.trending_down_icon'),
            default => config('filament-ga4.steady_icon')
        };
    }

    public function trajectoryDescription(): string
    {
        return static::thousandsFormater(abs($this->compute())).$this->format.' '.$this->trajectoryLabel();
    }

    public static function thousandsFormater($value, $with1k = false)
    {
        return match (true) {
            $value >= 1E9 => round($value / 1E12, 2).'t',
            $value >= 1E9 => round($value / 1E9, 2).'b',
            $value >= 1E6 => round($value / 1E6, 2).'m',
            ($value >= 1E3 && $with1k) => round($value / 1E3, 2).'k',
            default => (string) number_format($value),
        };
    }
}
