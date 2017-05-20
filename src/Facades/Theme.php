<?php

namespace Shipu\Themevel\Facades;

use Illuminate\Support\Facades\Facade;

class Theme extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Shipu\Themevel\Contracts\ThemeContract::class;
    }
}
