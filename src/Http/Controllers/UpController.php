<?php

namespace Minions\Polyfill\Http\Controllers;

use Illuminate\Http\Request;
use Psr\Http\Message\ServerRequestInterface;

class UpController
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(ServerRequestInterface $request)
    {
        return \response('OK', 200, ['Content-Type' => 'text/plain']);
    }
}
