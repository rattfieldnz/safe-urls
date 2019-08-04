<?php declare(strict_types = 1);

namespace RattfieldNz\SafeUrls\Libraries\Config;

use Orchestra\Testbench\TestCase;

class ConfigTest extends TestCase
{
    /** @var Config */
    private $config;

    protected function setUp(): void
    {
        $this->config = new Config();
    }

    public function testMissing()
    {
        $this->fail('Test not yet implemented');
    }
}
