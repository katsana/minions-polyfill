<?php

namespace Minions\Polyfill\Http\Controllers;

use Illuminate\Http\Request;
use Psr\Http\Message\ServerRequestInterface;

class RpcController
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(ServerRequestInterface $request)
    {
        $reply = \app('minions.router')->handle($request);

        return \response(
            $reply->body(), $reply->status(), $reply->headers()
        );
    }
}
