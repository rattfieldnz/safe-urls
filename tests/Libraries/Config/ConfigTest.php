<?php

declare(strict_types=1);

namespace RattfieldNz\SafeUrls\Tests\Libraries\Config;

use RattfieldNz\SafeUrls\Libraries\Config\Config;
use RattfieldNz\SafeUrls\Tests\TestCase;

class ConfigTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Test Google API key from config file.
     */
    public function testGoogleApiKey()
    {
        $expected = env('GOOGLE_API_KEY');
        $actual = Config::googleApiKey();
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test Google API Client Id from config file.
     */
    public function testClientId()
    {
        $expected = env('GOOGLE_CLIENT_ID');
        $actual = Config::clientId();
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test Google API Client Id from config file.
     */
    public function testClientVersion()
    {
        $expected = env('GOOGLE_CLIENT_VERSION');
        $actual = Config::clientVersion();
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test Google API Threat Types from config file.
     */
    public function testAllThreatTypes()
    {

        $expected = [
            'THREAT_TYPE_UNSPECIFIED',
            'MALWARE',
            'SOCIAL_ENGINEERING',
            'UNWANTED_SOFTWARE',
            'POTENTIALLY_HARMFUL_APPLICATION',
        ];

        $actual = Config::threatTypes();
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test Google API Platform Types from config file.
     */
    public function testAllPlatformTypes()
    {

        $expected = [
            'PLATFORM_TYPE_UNSPECIFIED',
            'WINDOWS',
            'LINUX',
            'ANDROID',
            'OSX',
            'IOS',
            'ANY_PLATFORM',
            'ALL_PLATFORMS',
            'CHROME',
        ];

        $actual = Config::platformTypes();
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test Google API Threat Entry Types from config file.
     */
    public function testAllThreatEntryTypes()
    {

        $expected = [
            'URL',
            'THREAT_ENTRY_TYPE_UNSPECIFIED',
        ];

        $actual = Config::threatEntryTypes();
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test Google API Curl Timeout from config file.
     */
    public function testCurlTimeout()
    {

        $expected = env('GOOGLE_CURL_TIMEOUT');
        $actual = Config::curlTimeout();
        $this->assertEquals($expected, $actual);

    }

}
