<?php

declare(strict_types=1);

namespace RattfieldNz\SafeUrls\Libraries\Curl;

use Orchestra\Testbench\TestCase;

class CurlTest extends TestCase
{
    /** @var Curl */
    private $curl;

    /** @var string */
    private $postUrl;

    /** @var array */
    private $headers;

    /** @var array */
    private $payload;

    /** @var int */
    private $timeout;

    protected function setUp(): void
    {
        $this->postUrl = '';
        $this->headers = [];
        $this->payload = [];
        $this->timeout = 10;
        $this->curl = new Curl(
            $this->postUrl,
            $this->headers,
            $this->payload,
            $this->timeout
        );
    }

    public function testMissing()
    {
        $this->fail('Test not yet implemented');
    }
}
