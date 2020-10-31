<?php

namespace Minions\Polyfill\Tests\Browser;

use Minions\Client\Message;
use Minions\Client\ResponseInterface;
use Minions\Minion;
use Minions\Polyfill\Tests\BrowserTestCase;
use Minions\Router;

class RpcRequestTest extends BrowserTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->tweakApplication(static function () {
            Router::rpc('math.add', 'Minions\Polyfill\Tests\JsonRpc\MathAdd');
        });
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $config = $app->make('config');

        $config->set([
            'minions.id' => 'server-project-id',
            'minions.projects' => [
                'client-project-id' => [
                    'token' => 'secret-token',
                    'signature' => 'secret-signature',
                ],
                'server-project-id' => [
                    'endpoint' => static::baseServeUrl().'/rpc',
                    'token' => 'secret-token',
                    'signature' => 'secret-signature',
                ],
            ],
        ]);
    }

    /** @test */
    public function it_can_make_rpc_request_from_a_client()
    {
        $promise = Minion::broadcast('server-project-id', new Message(
            'math.add', [1, 2, 3, 4], \time()
        ))->then(function (ResponseInterface $response) {
            $this->assertSame(10, $response->getRpcResult());
        });

        Minion::await($promise);
    }
}
