<?php

namespace Lakuapik\FilamentGA4\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static thousandsFormater()
 *
 * @see \Lakuapik\FilamentGA4\FilamentGA4
 */
class FilamentGA4 extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Lakuapik\FilamentGA4\FilamentGA4::class;
    }
}
