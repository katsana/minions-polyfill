<?php

namespace Minions\Polyfill;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class PolyfillServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerRouterMacro();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->bootRpcRoutes();
    }

    /**
     * Register Router Macro.
     *
     * @return void
     */
    protected function registerRouterMacro()
    {
        Router::macro('minion', function ($uri) {
            $this->match(['GET'], $uri, '\Minions\Polyfill\Http\Controllers\UpController');

            return $this->match(['POST'], $uri, '\Minions\Polyfill\Http\Controllers\RpcController');
        });
    }

    /**
     * Register rpc routes.
     */
    protected function bootRpcRoutes(): void
    {
        $routeFile = $this->app->basePath('routes/rpc.php');

        if (\file_exists($routeFile)) {
            require $routeFile;
        }
    }
}
