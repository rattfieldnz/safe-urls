<?php

namespace RattfieldNz\SafeUrls\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use RattfieldNz\SafeUrls\SafeUrlsServiceProvider;

abstract class TestCase extends Orchestra
{
    /**
     * add the package provider.
     *
     * @param $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [SafeUrlsServiceProvider::class];
    }
}
