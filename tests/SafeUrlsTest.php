<?php

declare(strict_types=1);

namespace RattfieldNz\SafeUrls;

use RattfieldNz\SafeUrls\Tests\TestCase;

class SafeUrlsTest extends TestCase
{
    /** @var SafeUrls */
    private $safeUrls;

    private $urlsToTest;

    protected function setUp():void
    {
        parent::setUp();

        $this->safeUrls = new SafeUrls();
        $this->urlsToTest = [
            'https://testsafebrowsing.appspot.com/s/phishing.html',
            'https://testsafebrowsing.appspot.com/s/malware.html',
            'http://testsafebrowsing.appspot.com/apiv4/ANY_PLATFORM/MALWARE/URL/',
            'http://testsafebrowsing.appspot.com/apiv4/ANY_PLATFORM/SOCIAL_ENGINEERING/URL/',
            'http://malware.testing.google.test/testing/malware/',
        ];
    }

    public function testAddUrls()
    {
        $this->safeUrls->add($this->urlsToTest);

        $expected = $this->urlsToTest;
        $actual = $this->safeUrls->getCurrentUrls(true);

        $this->assertEquals($expected, $actual);
    }

    public function testRemoveUrls()
    {
        $this->safeUrls->add($this->urlsToTest);
        $urlToRemove = 'https://testsafebrowsing.appspot.com/s/phishing.html';

        $expected = [
            $this->urlsToTest[1],
            $this->urlsToTest[2],
            $this->urlsToTest[3],
            $this->urlsToTest[4],
        ];
        $this->safeUrls->remove([$urlToRemove]);

        $actual = $this->safeUrls->getCurrentUrls(true);

        $this->assertEquals($expected, $actual);
    }

    public function testRemoveAllUrls()
    {
        $this->safeUrls->add($this->urlsToTest);

        $expected = [];
        $this->safeUrls->remove($this->urlsToTest);
        $actual = $this->safeUrls->getCurrentUrls(true);

        $this->assertEquals($expected, $actual);
    }

    public function testExecute()
    {

        // Only testing with returned HTTP status, as Google Safebrowsing API not working as
        // documented. See tests\Libraries\Curl\CurlTest testMalwareSocialEngineeringAnyPlatformUrl().

        $this->safeUrls->add($this->urlsToTest);

        $expected = '{ "status": 200, "response": { "matches": [ { "threatType": "SOCIAL_ENGINEERING", "platformType": "ANY_PLATFORM", "threat": { "url": "https://testsafebrowsing.appspot.com/s/phishing.html" }, "cacheDuration": "300s", "threatEntryType": "URL" }, { "threatType": "MALWARE", "platformType": "ANY_PLATFORM", "threat": { "url": "https://testsafebrowsing.appspot.com/s/malware.html" }, "cacheDuration": "300s", "threatEntryType": "URL" }, { "threatType": "MALWARE", "platformType": "ANY_PLATFORM", "threat": { "url": "http://testsafebrowsing.appspot.com/apiv4/ANY_PLATFORM/MALWARE/URL/" }, "cacheDuration": "300s", "threatEntryType": "URL" }, { "threatType": "SOCIAL_ENGINEERING", "platformType": "ANY_PLATFORM", "threat": { "url": "http://testsafebrowsing.appspot.com/apiv4/ANY_PLATFORM/SOCIAL_ENGINEERING/URL/" }, "cacheDuration": "300s", "threatEntryType": "URL" }, { "threatType": "MALWARE", "platformType": "ANY_PLATFORM", "threat": { "url": "http://malware.testing.google.test/testing/malware/" }, "cacheDuration": "300s", "threatEntryType": "URL" }, { "threatType": "SOCIAL_ENGINEERING", "platformType": "ANY_PLATFORM", "threat": { "url": "http://malware.testing.google.test/testing/malware/" }, "cacheDuration": "300s", "threatEntryType": "URL" } ] } }';

        $expected = json_decode($expected, true)['status'];
        $actual = json_decode((string) $this->safeUrls->execute()->getResults(), true)['status'];

        $this->assertEquals($expected, $actual);
    }

    public function testGetResults()
    {
        $this->testExecute();
    }

    public function testCheck()
    {
        $expected = '{ "status": 200, "response": { "matches": [ { "threatType": "SOCIAL_ENGINEERING", "platformType": "ANY_PLATFORM", "threat": { "url": "https://testsafebrowsing.appspot.com/s/phishing.html" }, "cacheDuration": "300s", "threatEntryType": "URL" }, { "threatType": "MALWARE", "platformType": "ANY_PLATFORM", "threat": { "url": "https://testsafebrowsing.appspot.com/s/malware.html" }, "cacheDuration": "300s", "threatEntryType": "URL" }, { "threatType": "MALWARE", "platformType": "ANY_PLATFORM", "threat": { "url": "http://testsafebrowsing.appspot.com/apiv4/ANY_PLATFORM/MALWARE/URL/" }, "cacheDuration": "300s", "threatEntryType": "URL" }, { "threatType": "SOCIAL_ENGINEERING", "platformType": "ANY_PLATFORM", "threat": { "url": "http://testsafebrowsing.appspot.com/apiv4/ANY_PLATFORM/SOCIAL_ENGINEERING/URL/" }, "cacheDuration": "300s", "threatEntryType": "URL" }, { "threatType": "MALWARE", "platformType": "ANY_PLATFORM", "threat": { "url": "http://malware.testing.google.test/testing/malware/" }, "cacheDuration": "300s", "threatEntryType": "URL" }, { "threatType": "SOCIAL_ENGINEERING", "platformType": "ANY_PLATFORM", "threat": { "url": "http://malware.testing.google.test/testing/malware/" }, "cacheDuration": "300s", "threatEntryType": "URL" } ] } }';
        $expected = json_decode($expected, true)['status'];

        $actual = json_decode($this->safeUrls::check($this->urlsToTest), true)['status'];

        $this->assertEquals($expected, $actual);
    }

    /**
     * @expectedException \ErrorException
     */
    public function testCheckThrowErrorException()
    {
        $this->safeUrls->add($this->urlsToTest);

        $safeUrlsMock = $this->getMockBuilder(SafeUrls::class)
            ->setMethods(['callStatic'])
            ->getMock();

        /** @scrutinizer ignore-call */
        $safeUrlsMock->method('callStatic')
            ->with(SafeUrls::class, 'check', $this->urlsToTest)
            ->willThrowException(new \ErrorException('Expected Exception was thrown'));

        /** @scrutinizer ignore-call */
        $safeUrlsMock->checkCallStatic($this->urlsToTest);
    }

    public function testIsDangerous()
    {
        $this->safeUrls->add($this->urlsToTest);
        $this->safeUrls->execute();

        $dangerousUrl = 'http://malware.testing.google.test/testing/malware/';

        // See tests\Libraries\Curl\CurlTest testMalwareSocialEngineeringAnyPlatformUrl().
        $expected = true;
        $actual = !$this->safeUrls->isDangerous($dangerousUrl);

        $this->assertEquals($expected, $actual);
    }
}
