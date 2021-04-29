<?php

declare(strict_types=1);

namespace RattfieldNz\SafeUrls\Tests\Traits;

use RattfieldNz\SafeUrls\Libraries\Traits\StaticCalling;
use RattfieldNz\SafeUrls\SafeUrls;
use RattfieldNz\SafeUrls\Tests\TestCase;

class StaticCallingTraitTest extends TestCase
{
    /**
     * @var SafeUrls
     */
    private $safeUrls;

    private $urlsToTest;

    protected function setUp(): void
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

    public function testStaticCallingMethod()
    {
        $className = SafeUrls::class;
        $methodName = 'check';

        $testClass = new class() {
            use StaticCalling;
        };

        // Only testing with returned HTTP status, as Google Safebrowsing API not working as
        // documented. See tests\Libraries\Curl\CurlTest testMalwareSocialEngineeringAnyPlatformUrl().
        $expected = 200;
        $actual = json_decode(
            $testClass->callStatic(
                $className,
                $methodName,
                $this->urlsToTest
            ),
            true
        )['status'];

        $this->assertEquals($expected, $actual);
    }
}
