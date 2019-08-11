<?php

namespace RattfieldNz\SafeUrls\Tests;

use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase as Orchestra;
use RattfieldNz\SafeUrls\Facades\SafeUrlsFacade;
use RattfieldNz\SafeUrls\SafeUrlsServiceProvider;

abstract class TestCase extends Orchestra
{
    /**
     * Load package service provider
     * @param Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [SafeUrlsServiceProvider::class];
    }


    /**
     * Load package alias
     * @param  Application $app
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'SafeUrls' => SafeUrlsFacade::class,
        ];
    }
}
