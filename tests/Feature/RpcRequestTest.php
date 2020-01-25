<?php

namespace Minions\Polyfill\Tests\Feature;

use Minions\Client\Message;
use Minions\Polyfill\Tests\TestCase;
use Minions\Router;

class RpcRequestTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->afterApplicationCreated(static function () {
            Router::rpc('math.add', 'Minions\Polyfill\Tests\Stubs\MathAdd');
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
                    'endpoint' => 'http://127.0.0.1:8000/rpc',
                    'token' => 'secret-token',
                    'signature' => 'secret-signature',
                ],
            ],
        ]);
    }

    /** @test */
    public function it_can_make_rpc_request_from_a_client()
    {
        $id = \time();
        $message = new Message('math.add', [1, 2, 3, 4], $id);

        $this->postJson('/rpc', json_decode($message->toJson(), true), [
            'X-Request-ID' => 'client-project-id',
            'Authorization' => 'Token secret-token',
            'X-Signature' => $message->signature('secret-signature'),
            'Content-Type' => 'application/json',
        ])->assertOk()
        ->assertJson([
            'jsonrpc' => '2.0',
            'id' => $id,
            'result' => 10,
        ]);
    }

    /** @test */
    public function it_cant_make_rpc_request_from_a_invalid_client()
    {
        $id = \time();
        $message = new Message('math.add', [1, 2, 3, 4], $id);

        $this->postJson('/rpc', json_decode($message->toJson(), true), [
            'X-Request-ID' => 'not-client-project-id',
            'Authorization' => 'Token secret-token',
            'X-Signature' => $message->signature('secret-signature'),
            'Content-Type' => 'application/json',
        ])->assertOk()
        ->assertJson([
            'jsonrpc' => '2.0',
            'id' => null,
            'error' => [
                'code' => -32600,
                'message' => 'Unable to find project: not-client-project-id',
            ],
        ]);
    }

    /** @test */
    public function it_cant_make_rpc_request_from_a_client_when_token_is_invalid()
    {
        $id = \time();
        $message = new Message('math.add', [1, 2, 3, 4], $id);

        $this->postJson('/rpc', json_decode($message->toJson(), true), [
            'X-Request-ID' => 'client-project-id',
            'Authorization' => 'Token not-secret-token',
            'X-Signature' => $message->signature('secret-signature'),
            'Content-Type' => 'application/json',
        ])->assertOk()
        ->assertJson([
            'jsonrpc' => '2.0',
            'id' => null,
            'error' => [
                'code' => -32652,
                'message' => 'Invalid Token.',
            ],
        ]);
    }

    /** @test */
    public function it_cant_make_rpc_request_from_a_client_when_signature_is_invalid()
    {
        $id = \time();
        $message = new Message('math.add', [1, 2, 3, 4], $id);

        $this->postJson('/rpc', json_decode($message->toJson(), true), [
            'X-Request-ID' => 'client-project-id',
            'Authorization' => 'Token secret-token',
            'X-Signature' => $message->signature('not-secret-signature'),
            'Content-Type' => 'application/json',
        ])->assertOk()
        ->assertJson([
            'jsonrpc' => '2.0',
            'id' => null,
            'error' => [
                'code' => -32652,
                'message' => 'Invalid Signature.',
            ],
        ]);
    }
}
