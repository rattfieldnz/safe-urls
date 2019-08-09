<?php

declare(strict_types=1);

namespace RattfieldNz\SafeUrls\Libraries\Data;

use RattfieldNz\SafeUrls\Libraries\Config\Config;
use RattfieldNz\SafeUrls\Tests\TestCase;

class DataTest extends TestCase
{
    private $_formattedUrls = [
        [ 'url' => 'https://www.google.com' ],
        [ 'url' => 'https://github.com' ],
        [ 'url' => 'https://github.styleci.io' ],
        [ 'url' => 'https://travis-ci.org' ],
        [ 'url' => 'https://packagist.org' ],
    ];

    private $_urls = [
        'https://www.google.com',
        'https://github.com',
        'https://github.styleci.io',
        'https://travis-ci.org',
        'https://packagist.org',
    ];

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testPayloadMultipleUrls()
    {
        $expected = self::_payload($this->_urls);

        $actual = Data::payload($this->_urls);
        $this->assertEquals($expected, $actual);
    }

    public function testPayloadSingleUrl()
    {
        $url = [
            'https://www.google.com',
        ];

        $expected = self::_payload($url);

        $actual = Data::payload($url);
        $this->assertEquals($expected, $actual);
    }

    public function testPayloadNoUrls()
    {
        $urls = [ ];

        $expected = self::_payload($urls);

        $actual = Data::payload($urls);
        $this->assertEquals($expected, $actual);
    }

    public function testFormatUrlsMultiple()
    {
        $expected = $this->_formattedUrls;

        $actual = Data::formatUrls($this->_urls);
        $this->assertEquals($expected, $actual);
    }

    public function testFormatUrlsSingle()
    {
        $url = [ 'https://www.google.com' ];

        $expected = [
            [ 'url' => 'https://www.google.com' ],
        ];

        $actual = Data::formatUrls($url);
        $this->assertEquals($expected, $actual);
    }

    public function testFormatUrlsNone()
    {
        $urls = [ ];

        $expected = [ ];

        $actual = Data::formatUrls($urls);
        $this->assertEquals($expected, $actual);
    }

    private static function _payload(array $urls, array $threatTypes = [ ], array $platformTypes = [ ], array $threatEntryTypes = [ ]): array
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
                'threatEntries'    => Data::formatUrls($urls),
            ],
        ];
    }
}
