Laravel SocketCluster
---------------------

**WARNING: This package is no longer maintained. Use [soleon/sc-php](https://github.com/soleon-leiloes/sc-php) instead.**

[![Build Status](https://travis-ci.org/naturalweb/laravel-socketcluster.svg?branch=master)](https://travis-ci.org/naturalweb/laravel-socketcluster)
[![Coverage Status](https://coveralls.io/repos/naturalweb/laravel-socketcluster/badge.png?branch=master&service=github)](https://coveralls.io/github/naturalweb/laravel-socketcluster?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/naturalweb/laravel-socketcluster/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/naturalweb/laravel-socketcluster/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/naturalweb/laravel-socketcluster/v/stable.png)](https://packagist.org/packages/naturalweb/laravel-socketcluster)
[![License](https://poser.pugx.org/naturalweb/laravel-socketcluster/license.png)](http://opensource.org/licenses/MIT)

[SocketCluster.io](http://socketcluster.io/) library broadcaster for Laravel.

Requirements
------------

* laravel >= 5.1
* textalk/websocket 1.0.* (retrieved automatically via Composer)

Installation
------------

Using Composer:

```sh
composer require naturalweb/laravel-socketcluster
```

In your config/app.php file add the following provider to your service providers array:

```php
'providers' => [
    ...
    LaravelSocketCluster\SCBroadcastServiceProvider::class,
    ...
]
```

In your config/broadcasting.php file set the default driver to 'socketcluster' and add the connection configuration like so:

```php
'default' => 'socketcluster',

'connections' => [
    ...
    'socketcluster' => [
      'driver' => 'socketcluster',
      'secure' => env('BROADCAST_SOCKETCLUSTER_SECURE', false),
      'host'   => env('BROADCAST_SOCKETCLUSTER_HOST', '127.0.0.1'),
      'port'   => env('BROADCAST_SOCKETCLUSTER_PORT', '3000'),
      'path'   => env('BROADCAST_SOCKETCLUSTER_PATH', '/socketcluster/'),
    ],
    ...
]
```

Usage
-----

Add a custom broadcast event to your application like so:

```php
namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PublishToSocketClusterEvent implements ShouldBroadcast
{
    use SerializesModels;

    public $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function broadcastOn()
    {
        return ['<channel>'];
    }
}
```

Now to publish in your application simply fire the event:

```php
event(new App\Events\PublishToSocketClusterEvent('Test publish!!'));
```
