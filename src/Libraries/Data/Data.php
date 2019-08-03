<?php

namespace RattfieldNz\SafeUrls\Libraries\Data;

/**
 * Class Data.
 *
 * @category PHP
 * @package  SafeUrls\Libraries\Data
 * @author   Rob Attfield <emailme@robertattfield.com>
 * @license  https://github.com/rattfieldnz/safe-urls/blob/master/license.md MIT
 * @link     https://github.com/rattfieldnz/safe-urls/
 */
class Data
{
    /**
     * Generate payload for Google Safe Browsing API.
     *
     * @param array $urls List of URLS to add to payload for checking.
     *
     * @return array The generated payload.
     */
    public static function payload(array $urls): array
    {
        return [];
    }

    /**
     * Format URLS suitable for use with API.
     *
     * @param array $urls List of URLS to format.
     *
     * @return array The formatted URLs.
     */
    public static function formatUrls(array $urls): array
    {
        return [];
    }
}
