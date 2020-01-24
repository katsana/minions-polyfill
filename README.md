Minions Component Server (Polyfill) using Laravel Routing
===================

* [Installation](#installation)
* [Usages](#usages)

## Installation

Minions can be installed via composer:

```
composer require "katsana/minions-polyfill=^1.0"
```

Please ensure that you already install **Minions** and go through the [installation and setup documentation](https://github.com/katsana/minions).

## Usages

To use Laravel Routing to handle RPC request you just need to setup the URI and TLD domain to handle the request. To do this this package has already add a macro to `Illuminate\Routing\Router`.

It is recommended that you add the command to `App\Providers\RouteServiceProvider::map()` method.

```php
<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    // ...
    
     /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        Route::minion('rpc');
    }

    // ...
}
```

You can also set it to a specific domain using the following:

```php
Route::minion('/', 'rpc.your-domain');
```
