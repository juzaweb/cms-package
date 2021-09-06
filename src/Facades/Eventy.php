<?php

namespace Juzaweb\Cms\Facades;

use Illuminate\Support\Facades\Facade;
use Juzaweb\Cms\Contracts\EventyContract;

class Eventy extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return EventyContract::class;
    }
}
