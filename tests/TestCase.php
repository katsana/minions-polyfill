<?php

namespace Minions\Polyfill\Tests;

use Illuminate\Support\Facades\Route;

abstract class TestCase extends \Orchestra\Testbench\TestCase
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
            \Minions\Server\MinionsServiceProvider::class,
            \Minions\Polyfill\PolyfillServiceProvider::class,
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
