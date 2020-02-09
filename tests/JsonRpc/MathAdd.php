<?php

namespace Minions\Polyfill\Tests\JsonRpc;

class MathAdd
{
    public function __invoke(array $arguments)
    {
        return \array_sum($arguments);
    }
}
