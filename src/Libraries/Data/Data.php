<?php

namespace RattfieldNz\SafeUrls\Libraries\Data;

/**
 * Class Data
 *
 * @author  Rob Attfield <emailme@robertattfield.com> <https://github.com/rattfieldnz>
 * @package RattfieldNz\SafeUrls\Libraries\Data
 */
class Data
{
    /**
     * Generate payload for Google Safe Browsing API.
     *
     * @param  array $urls
     * @return array The generated payload.
     */
    public static function payload(array $urls): array
    {
        return [];
    }

    /**
     * Format URLS suitable for use with API.
     *
     * @param  array $urls
     * @return array The formatted URLs.
     */
    public static function formatUrls(array $urls): array
    {
        return [];
    }
}
