# WebFramework Redis Module

This module provides Redis caching integration for WebFramework.

## Requirements

- PHP 8.2 or higher
- Redis server
- WebFramework 8.x

## Installation

Install via Composer:

```bash
composer require avoutic/web-framework-redis
```

Make sure the definitions file is included in your project by adding it to `definition_files` in your `config.php` file:

```php
return [
    'definition_files' => [
        '../vendor/avoutic/web-framework/definitions/definitions.php',
        '../vendor/avoutic/web-framework-redis/definitions/definitions.php',
        'app_definitions.php',
    ],
];
```

## Usage

The module provides Redis integration for WebFramework, enabling Redis caching. It implements the WebFramework Cache interface to cache data.

To use Redis for caching you need to add it in your PHP-DI definitions:

```php
return [
    Cache::class => DI\autowire(RedisCache::class),
];
```

## Configuration

If you are using the definition from _definitions/defitinions.php_. You can just add the following _redis.php_ to your auth config directory (_config/auth_):

```php
<?php

return [
    'hostname' => env('REDIS_HOSTNAME', 'localhost'),
    'port' => env('REDIS_PORT', 6379),
    'password' => env('REDIS_PASSWORD', '')
]
```

## Features

- Redis-based caching implementation
- Support for cache tags
- Automatic instrumentation for performance tracking
- PSR-16 compliant cache interface

## License

MIT License - see LICENSE file for details 