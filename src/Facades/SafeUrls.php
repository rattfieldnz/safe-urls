<?php

namespace RattfieldNz\SafeUrls\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class SafeUrls.
 *
 * @category PHP
 *
 * @author   Rob Attfield <emailme@robertattfield.com>
 * @license  https://github.com/rattfieldnz/safe-urls/blob/master/license.md MIT
 *
 * @link     https://github.com/rattfieldnz/safe-urls/
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
