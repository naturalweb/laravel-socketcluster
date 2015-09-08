<?php

namespace LaravelSocketCluster;

use \Illuminate\Contracts\Broadcasting\Broadcaster;
use LaravelSocketCluster\SocketCluster;

/**
 * @package SocketCluster\SCBroadcaster
 */
class SCBroadcaster implements Broadcaster
{
    /**
     * @var SocketCluster\SocketCluster
     */
    protected $socketcluster;

    /**
     * Construct
     *
     * @param SocketCluster $socketcluster
     *
     * @param void
     */
    public function __construct(SocketCluster $socketcluster)
    {
        $this->socketcluster = $socketcluster;
    }

    /**
     * Broadcast
     *
     * @param array  $channels
     * @param string $event
     * @param array  $payload
     *
     * @return void
     */
    public function broadcast(array $channels, $event, array $payload = array())
    {
        foreach ($channels as $channel) {
            $this->socketcluster->publish($channel, $payload);
        }
    }
}