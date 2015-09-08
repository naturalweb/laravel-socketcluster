<?php

namespace LaravelSocketCluster;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Illuminate\Broadcasting\BroadcastManager;
use WebSocket\Client as WebSocketClient;

class SCBroadcastServiceProvider extends BaseServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Register new BroadcastManager in boot
     *
     * @return void
     */
    public function boot()
    {
        $self = $this;

        $this->app
            ->make(BroadcastManager::class)
            ->extend('socketcluster', function ($app, $config) use ($self) {
                return new SCBroadcaster($self->makeSocketCluster($config));
            });
    }

    /**
     * Register service SocketCluster
     *
     * @return void
     */
    protected function makeSocketCluster($config)
    {
        if (empty($config['uri'])) {
            $scheme = $config['secure']==true ? 'wss' : 'ws';
            $host   = trim($config['host'], "/");
            $port   = !empty($config['port']) ? ":".$config['port'] : '';
            $path   = trim($config['path'], "/");
            $config['uri'] = sprintf("%s://%s%s/%s/", $scheme, $host, $port, $path);
        }
        
        return new SocketCluster(new WebSocketClient($config['uri']));
    }
}