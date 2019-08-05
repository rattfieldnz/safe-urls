<?php

namespace RattfieldNz\SafeUrls\Libraries\Data;

use RattfieldNz\SafeUrls\Libraries\Config\Config;

/**
 * Class Data.
 *
 * @category PHP
 *
 * @author   Rob Attfield <emailme@robertattfield.com>
 * @license  https://github.com/rattfieldnz/safe-urls/blob/master/license.md MIT
 *
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
        return [
            'client' => [
                'clientId'      => Config::clientId(),
                'clientVersion' => Config::clientVersion(),
            ],
            'threatInfo' => [
                'threatTypes'      => Config::threatTypes(),
                'platformTypes'    => Config::platformTypes(),
                'threatEntryTypes' => Config::threatEntryTypes(),
                'threatEntries'    => self::formatUrls($urls),
            ],
        ];
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
        $formattedUrls = [];
        foreach ($urls as $url) {
            $formattedUrls[] = ['url' => $url];
        }

        return $formattedUrls;
    }
}
