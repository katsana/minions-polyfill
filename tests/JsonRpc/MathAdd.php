<?php

namespace Minions\Polyfill\Tests\JsonRpc;

use Minions\Http\Request;

class MathAdd
{
    public function __invoke($arguments)
    {
        if (\is_array($arguments)) {
            return \array_sum($arguments);
        } elseif ($arguments instanceof Request) {
            return \array_sum($arguments->all());
        }
    }
}
