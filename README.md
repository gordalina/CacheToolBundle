CacheToolBundle
===============

This bundle allows you to integrate [CacheTool](https://github.com/gordalina/cachetool) with Symfony2.

Installation
------------

```json
{
    "require": {
        "gordalina/cachetool-bundle": "~1.0"
    }
}
```

Register the bundle in `app/Appkernel.php`:

```php
// app/AppKernel.php

public function registerBundles()
{
    return array(
        // ...
        new CacheTool\Bundle\CacheToolBundle(),
    );
}
```

Enable the bundle's configuration in `app/config/config.yml`:

```yml
# app/config/config.yml
cachetool: ~
```

Configuration
-------------

There are only two possible configurations

1. Using CLI

```yml
# app/config/config.yml
cachetool:
    adapter: cli
```

2. Using FastCGI

```yml
# app/config/config.yml
cachetool:
    adapter: fastcgi
    fastcgi: 127.0.0.1:900
```

You can also connect by socket replacing the above by: `/var/run/php5-fpm.sock`.

Usage
-----

### Commands

```sh
  cachetool:apc:bin:dump                   Get a binary dump of files and user variables
  cachetool:apc:bin:load                   Load a binary dump into the APC file and user variables
  cachetool:apc:cache:info                 Shows APC user & system cache information
  cachetool:apc:cache:info:file            Shows APC file cache information
  cachetool:apc:key:delete                 Deletes an APC key
  cachetool:apc:key:exists                 Checks if an APC key exists
  cachetool:apc:key:fetch                  Shows the content of an APC key
  cachetool:apc:key:store                  Store an APC key with given value
  cachetool:apc:sma:info                   Show APC shared memory allocation information
  cachetool:cache:clear:dump               Clears APC cache (user, system or all)
  cachetool:opcache:configuration          Get configuration information about the cache
  cachetool:opcache:reset                  Resets the contents of the opcode cache
  cachetool:opcache:status                 Show summary information about the opcode cache
  cachetool:opcache:status:scripts         Show scripts in the opcode cache
```

### Service

You can access all `apc` and `opcode` functions through the `cachetool` service.

```php

$cache = $container->get('cachetool');
$cache->apc_clear_cache('both');
// or
$cache->opcache_reset();

### Extending CacheTool

CacheTool depends on `Proxies` to provide functionality, by default when creating a CacheTool instance from the factory
all proxies are enabled [`ApcProxy`](https://github.com/gordalina/cachetool/blob/master/src/CacheTool/Proxy/ApcProxy.php), [`OpcacheProxy`](https://github.com/gordalina/cachetool/blob/master/src/CacheTool/Proxy/OpcacheProxy.php) and [`PhpProxy`](https://github.com/gordalina/cachetool/blob/master/src/CacheTool/Proxy/PhpProxy.php), you can customize it or extend to your will like the example below:

```php
use CacheTool\Adapter\FastCGI;
use CacheTool\CacheTool;
use CacheTool\Proxy;

$adapter = new FastCGI('/var/run/php5-fpm.sock');
$cache = new CacheTool();
$cache->setAdapter($adapter);
$cache->addProxy(new Proxy\ApcProxy());
$cache->addProxy(new Proxy\PhpProxy());
```

You can read more information at [CacheTool](https://github.com/gordalina/cachetool)'s page.

License
-------

This bundle is released under the MIT license. [See the complete license in the bundle.](https://github.com/gordalina/CacheToolBundle/blob/master/LICENSE)
