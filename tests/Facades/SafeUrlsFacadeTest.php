<?php

declare(strict_types=1);

namespace RattfieldNz\SafeUrls\Tests\Facades;

use Illuminate\Foundation\Application;
use Prophecy\Prophet;
use RattfieldNz\SafeUrls\Facades\SafeUrlsFacade;
use RattfieldNz\SafeUrls\SafeUrls;
use RattfieldNz\SafeUrls\Tests\TestCase;;

class SafeUrlsFacadeTest extends TestCase
{
    protected $app;

    protected $prophet;

    protected function setUp():void
    {
        parent::setUp();

        $this->prophet = new Prophet();

        $this->app = $this->prophet->prophesize(Application::class);

        $this->app->offsetGet('safe-urls')
            ->willReturn((new SafeUrls()));

        SafeUrlsFacade::setFacadeApplication($this->app->reveal());
    }

    public function testFacadesWorksAsExpected()
    {
        $this->assertInstanceOf(
            SafeUrls::class,
            SafeUrlsFacade::getFacadeRoot()
        );
    }

    public function testSafeUrlsFacadeFacadeAdd()
    {

        $urls = ['https://google.com'];
        SafeUrlsFacade::add($urls);

        $expected = $urls;

        // Retrieves $urls which were added.
        $actual = SafeUrlsFacade::getCurrentUrls(true);

        $this->assertEquals($expected, $actual);
    }

    public function testSafeUrlsFacadeFacadeRemove()
    {
        $urls = ['https://google.com', 'https://github.com'];
        SafeUrlsFacade::add($urls);

        $expected = ['https://google.com'];
        SafeUrlsFacade::remove(['https://github.com']);

        $actual = SafeUrlsFacade::getCurrentUrls(true);

        $this->assertEquals($expected, $actual);
    }

    public function testSafeUrlsFacadeGetCurrentUrls()
    {
        $urls = ['https://google.com', 'https://github.com'];
        SafeUrlsFacade::add($urls);

        $expected = $urls;

        // Retrieves $urls which were added.
        $actual = SafeUrlsFacade::getCurrentUrls(true);

        $this->assertEquals($expected, $actual);
    }

    public function testSafeUrlsFacadeGetResults()
    {
        $urls = ['https://google.com', 'https://github.com'];
        SafeUrlsFacade::add($urls);

        SafeUrlsFacade::execute();

        $expected = '{"status":200,"response":[]}';
        $actual = SafeUrlsFacade::getResults();

        $this->assertEquals($expected, $actual);
    }

    public function testSafeUrlsFacadeIsDangerous()
    {

        // Test to see if url is not dangerous.
        $urls = ['https://google.com', 'https://github.com'];
        SafeUrlsFacade::add($urls);

        SafeUrlsFacade::execute();

        $expected = false;
        $actual = SafeUrlsFacade::isDangerous('https://google.com');

        $this->assertEquals($expected, $actual);

        // Test to see if url is dangerous.
        $passedInResults = '{ "status": 200, "response": { "matches": [ { "threatType": "SOCIAL_ENGINEERING", "platformType": "ANY_PLATFORM", "threat": { "url": "https://testsafebrowsing.appspot.com/s/phishing.html" }, "cacheDuration": "300s", "threatEntryType": "URL" }, { "threatType": "MALWARE", "platformType": "ANY_PLATFORM", "threat": { "url": "https://testsafebrowsing.appspot.com/s/malware.html" }, "cacheDuration": "300s", "threatEntryType": "URL" }, { "threatType": "MALWARE", "platformType": "ANY_PLATFORM", "threat": { "url": "http://testsafebrowsing.appspot.com/apiv4/ANY_PLATFORM/MALWARE/URL/" }, "cacheDuration": "300s", "threatEntryType": "URL" }, { "threatType": "SOCIAL_ENGINEERING", "platformType": "ANY_PLATFORM", "threat": { "url": "http://testsafebrowsing.appspot.com/apiv4/ANY_PLATFORM/SOCIAL_ENGINEERING/URL/" }, "cacheDuration": "300s", "threatEntryType": "URL" }, { "threatType": "MALWARE", "platformType": "ANY_PLATFORM", "threat": { "url": "http://malware.testing.google.test/testing/malware/" }, "cacheDuration": "300s", "threatEntryType": "URL" }, { "threatType": "SOCIAL_ENGINEERING", "platformType": "ANY_PLATFORM", "threat": { "url": "http://malware.testing.google.test/testing/malware/" }, "cacheDuration": "300s", "threatEntryType": "URL" } ] } }';
        $dangerousUrl = 'http://malware.testing.google.test/testing/malware/';

        $expected = true;
        $actual = SafeUrlsFacade::isDangerous($dangerousUrl, $passedInResults);

        $this->assertEquals($expected, $actual);
    }
}
