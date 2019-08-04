<?php

namespace RattfieldNz\SafeUrls\Libraries\Config;

/**
 * Class Config.
 *
 * @category PHP
 *
 * @author  Rob Attfield <emailme@robertattfield.com>
 * @license https://github.com/rattfieldnz/safe-urls/blob/master/license.md MIT
 *
 * @link https://github.com/rattfieldnz/safe-urls/
 */
class Config
{
    // Default entry type
    public const DEFAULT_THREAT_ENTRY_TYPE = 'URL';

    // Default timeout for API call.
    public const DEFAULT_TIMEOUT = 10;

    /**
     * Retrieve the Google API key.
     *
     * @return string The Google API key.
     */
    public static function googleApiKey(): string
    {
        $key = config('safe-urls.google.api_key');
        return !empty($key) ? $key : "";
    }

    /**
     * Retrieve Google API client id.
     *
     * @return string The Google API client id.
     */
    public static function clientId(): string
    {
        $clientId = config('safe-urls.google.clientId');
        return !empty($clientId) ? $clientId : "";
    }

    /**
     * Retrieve the Google API client version.
     *
     * @return string The Google API client version.
     */
    public static function clientVersion(): string
    {
        $clientVersion = config('safe-urls.google.clientVersion');
        return !empty($clientVersion) ? $clientVersion : "";
    }

    /**
     * Retrieve Google Safe Browsing API threat types.
     *
     * @return array Threat types.
     */
    public static function threatTypes(): array
    {
        $threatTypes = config('safe-urls.google.threat_types');
        return !empty($threatTypes) ? $threatTypes : [];

    }

    /**
     * Retrieve Google Safe Browsing API platform types.
     *
     * @return array Platforms where threats can occur.
     */
    public static function platformTypes(): array
    {
        $platformTypes = config('safe-urls.google.threat_platform_types');
        return !empty($platformTypes) ? $platformTypes : [];

    }

    /**
     * Retrieve Google Safe Browsing API threat entry types.
     *
     * @return array Threat entry types.
     */
    public static function threatEntryTypes(): array
    {
        $threatEntryTypes = config('safe-urls.google.threat_entry_types');
        return !empty($threatEntryTypes) ? $threatEntryTypes : [self::DEFAULT_THREAT_ENTRY_TYPE];
    }

    /**
     * Retrieve set CURL timeout from config, in seconds.
     *
     * @return int CURL timeout. Default is 10.
     */
    public static function curlTimeout(): int
    {
        $timeout = config('safe-urls.google.timeout');
        return !empty($timeout) ? intval($timeout) : self::DEFAULT_TIMEOUT;
    }
}
