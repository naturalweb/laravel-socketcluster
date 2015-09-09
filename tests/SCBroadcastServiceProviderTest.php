<?php

namespace Tests;

use Tests\TestCase;
use Mockery as m;
use LaravelSocketCluster\SCBroadcastServiceProvider;

class SCBroadcastServiceProviderTest extends TestCase
{
    public function testShouldBoot()
    {
        $app = m::mock('Illuminate\Contracts\Foundation\Application');
        $app->shouldReceive('make')->once()->with('Illuminate\Broadcasting\BroadcastManager')->andReturn($app);
        $app->shouldReceive('extend')->once()->andReturnUsing(function ($driver, $callback) use ($app) {
            $this->assertEquals('socketcluster', $driver);

            $config = [];
            $config['secure'] = true;
            $config['host'] = 'localhost';
            $config['port'] = 3000;
            $config['path'] = '/socketcluster/';

            $return = $callback($app, $config);
            $this->assertInstanceOf('LaravelSocketCluster\SCBroadcaster', $return);

            $uri = 'wss://localhost:3000/socketcluster/';
            $ws = new \WebSocket\Client($uri);
            $sc = new \LaravelSocketCluster\SocketCluster($ws);
            $bc = new \LaravelSocketCluster\SCBroadcaster($sc);
            $this->assertEquals($bc, $return);
        });

        $sp = new SCBroadcastServiceProvider($app);

        $sp->boot();

        $this->assertNull($sp->register());
    }
}