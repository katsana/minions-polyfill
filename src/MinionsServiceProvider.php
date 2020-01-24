<?php

namespace Minions\Polyfill;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class MinionsServiceProvider extends ServiceProvider
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
        //
    }

    /**
     * Register Router Macro.
     *
     * @return void
     */
    protected function registerRouterMacro()
    {
        Router::macro('minion', function ($prefix, $domain = null) {
            $router = $this->namespace('\Minions\Polyfill\Http\Controllers')
                ->prefix($prefix);

            if (! \is_null($domain)) {
                $router->domain($domain);
            }

            return $router->group(static function ($router) {
                $router->get('/', 'UpController');
                $router->post('/', 'RpcController');
            });
        });
    }
}
