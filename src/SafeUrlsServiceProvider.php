<?php

namespace RattfieldNz\SafeUrls;

use Illuminate\Support\ServiceProvider;

/**
 * Class SafeUrlsServiceProvider
 *
 * @author Rob Attfield <emailme@robertattfield.com> <https://github.com/rattfieldnz>
 * @package RattfieldNz\SafeUrls
 */
class SafeUrlsServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/safe-urls.php' => config_path('safe-urls.php'),
        ]);

        // use the vendor configuration file as fallback
        $this->mergeConfigFrom(
            __DIR__ . '/../config/safe-urls.php', 'safe-urls'
        );
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/safe-urls.php', 'safe-urls');

        // Register the service the package provides.
        $this->app->singleton('safe-urls', function () {
            return new SafeUrls();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['safe-urls'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__ . '/../config/safe-urls.php' => config_path('SafeUrls.php'),
        ], 'safe-urls.config');

        // Registering package commands.
        $this->commands(['safe-urls']);
    }
}
