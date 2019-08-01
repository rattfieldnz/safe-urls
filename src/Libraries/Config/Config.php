<?php

namespace RattfieldNz\SafeUrls\Libraries\Config;

/**
 * Class Config.
 *
 * @author  Rob Attfield <emailme@robertattfield.com> <https://github.com/rattfieldnz>
 */
class Config
{
    // Default entry type
    public const DEFAULT_THREAT_ENTRY_TYPE = 'URL';

    /**
     * Retrieve the Google API key.
     *
     * @return string The Google API key.
     */
    public static function googleApiKey(): string
    {
        return '';
    }

    /**
     * Retrieve Google API client id.
     *
     * @return string The Google API client id.
     */
    public static function clientId(): string
    {
        return '';
    }

    /**
     * Retrieve the Google API client version.
     *
     * @return string The Google API client version.
     */
    public static function clientVersion(): string
    {
        return '';
    }

    /**
     * Retrieve Google Safe Browsing API threat types.
     *
     * @return array Threat types.
     */
    public static function threatTypes(): array
    {
        return [];
    }

    /**
     * Retrieve Google Safe Browsing API platform types.
     *
     * @return array Platforms where threats can occur.
     */
    public static function platformTypes(): array
    {
        return [];
    }

    /**
     * Retrieve Google Safe Browsing API threat entry types.
     *
     * @return array Threat entry types.
     */
    public static function threatEntryTypes(): array
    {
        return [self::DEFAULT_THREAT_ENTRY_TYPE];
    }

    /**
     * Retrieve set CURL timeout from config, in seconds.
     *
     * @return int CURL timeout. Default is 10.
     */
    public static function curlTimeout(): int
    {
        return 10;
    }
}
