<?php

namespace Minions\Polyfill\Tests;

use Illuminate\Support\Facades\Route;

abstract class BrowserTestCase extends \Orchestra\Testbench\Dusk\TestCase
{
    /**
     * Get package providers.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            \Laravie\Stream\Laravel\StreamServiceProvider::class,
            \Minions\MinionsServiceProvider::class,
            \Minions\Http\MinionsServiceProvider::class,
            \Minions\Polyfill\MinionsServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        Route::minion('rpc');
    }
}
