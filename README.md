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

License
-------

This bundle is released under the MIT license. [See the complete license in the bundle.](https://github.com/gordalina/CacheToolBundle/blob/master/LICENSE)
