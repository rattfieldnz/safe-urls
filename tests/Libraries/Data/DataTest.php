<?php

declare(strict_types=1);

namespace RattfieldNz\SafeUrls\Libraries\Data;

use RattfieldNz\SafeUrls\Libraries\Config\Config;
use RattfieldNz\SafeUrls\Tests\TestCase;

class DataTest extends TestCase
{
    private $formattedUrls = [
        ['url' => 'https://www.google.com'],
        ['url' => 'https://github.com'],
        ['url' => 'https://github.styleci.io'],
        ['url' => 'https://travis-ci.org'],
        ['url' => 'https://packagist.org'],
    ];

    private $urls = [
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
        $expected = [
            'client' => [
                'clientId'      => Config::clientId(),
                'clientVersion' => Config::clientVersion(),
            ],
            'threatInfo' => [
                'threatTypes'      => Config::threatTypes(),
                'platformTypes'    => Config::platformTypes(),
                'threatEntryTypes' => Config::threatEntryTypes(),
                'threatEntries'    => $this->formattedUrls,
            ],
        ];

        $actual = Data::payload($this->urls);
        $this->assertEquals($expected, $actual);
    }

    public function testPayloadSingleUrl()
    {
        $formattedUrl = [
            ['url' => 'https://www.google.com'],
        ];

        $url = [
            'https://www.google.com',
        ];

        $expected = [
            'client' => [
                'clientId'      => Config::clientId(),
                'clientVersion' => Config::clientVersion(),
            ],
            'threatInfo' => [
                'threatTypes'      => Config::threatTypes(),
                'platformTypes'    => Config::platformTypes(),
                'threatEntryTypes' => Config::threatEntryTypes(),
                'threatEntries'    => $formattedUrl,
            ],
        ];

        $actual = Data::payload($url);
        $this->assertEquals($expected, $actual);
    }

    public function testPayloadNoUrls()
    {
        $formattedUrls = [
            //['url' => ''],
        ];

        $urls = [];

        $expected = [
            'client' => [
                'clientId'      => Config::clientId(),
                'clientVersion' => Config::clientVersion(),
            ],
            'threatInfo' => [
                'threatTypes'      => Config::threatTypes(),
                'platformTypes'    => Config::platformTypes(),
                'threatEntryTypes' => Config::threatEntryTypes(),
                'threatEntries'    => $formattedUrls,
            ],
        ];

        $actual = Data::payload($urls);
        $this->assertEquals($expected, $actual);
    }

    public function testFormatUrlsMultiple()
    {
        $expected = $this->formattedUrls;

        $actual = Data::formatUrls($this->urls);
        $this->assertEquals($expected, $actual);
    }

    public function testFormatUrlsSingle()
    {
        $url = ['https://www.google.com'];

        $expected = [
            ['url' => 'https://www.google.com'],
        ];

        $actual = Data::formatUrls($url);
        $this->assertEquals($expected, $actual);
    }

    public function testFormatUrlsNone()
    {
        $urls = [];

        $expected = [];

        $actual = Data::formatUrls($urls);
        $this->assertEquals($expected, $actual);
    }
}
