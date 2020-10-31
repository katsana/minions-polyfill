Minions Component Server (Polyfill) using Laravel Routing
===================

[![tests](https://github.com/katsana/minions-polyfill/workflows/tests/badge.svg?branch=master)](https://github.com/katsana/minions-polyfill/actions?query=branch%3Amaster+workflow%3Atests)
[![Latest Stable Version](https://poser.pugx.org/katsana/minions-polyfill/v/stable)](https://packagist.org/packages/katsana/minions-polyfill)
[![Total Downloads](https://poser.pugx.org/katsana/minions-polyfill/downloads)](https://packagist.org/packages/katsana/minions-polyfill)
[![Latest Unstable Version](https://poser.pugx.org/katsana/minions-polyfill/v/unstable)](https://packagist.org/packages/katsana/minions-polyfill)
[![License](https://poser.pugx.org/katsana/minions-polyfill/license)](https://packagist.org/packages/katsana/minions-polyfill)
[![Coverage Status](https://coveralls.io/repos/github/katsana/minions-polyfill/badge.svg?branch=master)](https://coveralls.io/github/katsana/minions-polyfill?branch=master)

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
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        Route::minion('rpc');

        parent::boot();
    }

    // ...
}
```

You can also set it to a specific domain using the following:

```php
Route::minion('/', 'rpc.your-domain');
```
