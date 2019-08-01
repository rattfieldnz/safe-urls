<?php

namespace RattfieldNz\SafeUrls\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class SafeUrls
 *
 * @author  Rob Attfield <emailme@robertattfield.com> <https://github.com/rattfieldnz>
 * @package RattfieldNz\SafeUrls\Facades
 */
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
