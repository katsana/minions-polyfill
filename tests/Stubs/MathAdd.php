<?php

namespace Minions\Polyfill\Tests\Stubs;

class MathAdd
{
    public function __invoke(array $arguments)
    {
        return \array_sum($arguments);
    }
}
