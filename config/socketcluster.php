<?php
return [
    
    'secure' => env('SOCKET_CLUSTER_SECURE', false),

    'host'   => env('SOCKET_CLUSTER_HOST', '127.0.0.1'),

    'port'   => env('SOCKET_CLUSTER_PORT', '3000'),

    'path'   => env('SOCKET_CLUSTER_PATH', '/socketcluster/'),

    'uri'    => env('SOCKET_CLUSTER_URI', null),
];