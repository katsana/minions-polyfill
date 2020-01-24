<?php

namespace Minions\Polyfill\Tests\Feature;

use Minions\Polyfill\Tests\TestCase;

class UpStatusPageTest extends TestCase
{
    /** @test */
    public function it_can_show_service_is_up()
    {
        $this->get('/rpc')
            ->assertOk()
            ->assertSee('OK');
    }
}
