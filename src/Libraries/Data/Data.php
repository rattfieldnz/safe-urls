<?php

namespace RattfieldNz\SafeUrls\Libraries\Data;

use RattfieldNz\SafeUrls\Libraries\Config\Config;

/**
 * Class Data.
 *
 * @category PHP
 *
 * @author  Rob Attfield <emailme@robertattfield.com>
 * @license https://github.com/rattfieldnz/safe-urls/blob/master/license.md MIT
 *
 * @link https://github.com/rattfieldnz/safe-urls/
 */
class Data
{
    /**
     * Generate payload for Google Safe Browsing API.
     *
     * @param array $urls             List of URLS to add to payload for checking.
     * @param array $threatTypes      List of Google Threat Types.
     * @param array $platformTypes    List of Google Platform Types.
     * @param array $threatEntryTypes List of Google Threat Platform Types.
     *
     * @return array The generated payload.
     */
    public static function payload(array $urls, array $threatTypes = [ ], array $platformTypes = [ ], array $threatEntryTypes = [ ]): array
    {
        return [
            'client' => [
                'clientId'      => Config::clientId(),
                'clientVersion' => Config::clientVersion(),
            ],
            'threatInfo' => [
                'threatTypes'      => !empty($threatTypes) ? $threatTypes : Config::threatTypes(),
                'platformTypes'    => !empty($platformTypes) ? $platformTypes : Config::platformTypes(),
                'threatEntryTypes' => !empty($threatEntryTypes) ? $threatEntryTypes : Config::threatEntryTypes(),
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
        $formattedUrls = [ ];
        foreach ($urls as $url) {
            $formattedUrls[ ] = [ 'url' => $url ];
        }

        return $formattedUrls;
    }

    /**
     * Get Google Safebrowing API URL with key.
     *
     * @return string
     */
    public static function googleApiUrl()
    {
        return 'https://safebrowsing.googleapis.com/v4/threatMatches:find?key='.
            Config::googleApiKey();
    }
}
