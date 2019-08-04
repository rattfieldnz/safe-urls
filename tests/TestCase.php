<?php

namespace RattfieldNz\SafeUrls\Tests;

use RattfieldNz\SafeUrls\SafeUrlsServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    /**
     * add the package provider
     *
     * @param $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [SafeUrlsServiceProvider::class];
    }
}
