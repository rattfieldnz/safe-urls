<?php

namespace RattfieldNz\SafeUrls\Facades;

use Illuminate\Support\Facades\Facade;

class SafeUrls extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'safe-urls';
    }
}
