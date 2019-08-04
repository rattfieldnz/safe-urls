<?php

declare(strict_types=1);

namespace RattfieldNz\SafeUrls\Libraries\Data;

use Orchestra\Testbench\TestCase;

class DataTest extends TestCase
{
    /** @var Data */
    private $data;

    protected function setUp(): void
    {
        $this->data = new Data();
    }

    public function testMissing()
    {
        $this->fail('Test not yet implemented');
    }
}
