<?php

declare(strict_types=1);

namespace RattfieldNz\SafeUrls;

use Orchestra\Testbench\TestCase;

class SafeUrlsTest extends TestCase
{
    /** @var SafeUrls */
    private $safeUrls;

    protected function setUp():void
    {
        $this->safeUrls = new SafeUrls();
    }

    public function testMissing()
    {
        $this->assertTrue(true);
    }
}
