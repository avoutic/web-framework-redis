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

## Configuration

If you are using the definition from _definitions/defitinions.php_. You can just add the following _redis.php_ to your auth config directory (_config/auth_):

```php
<?php

return [
    'hostname' => 'localhost',
    'port' => 6379,
    'password' => 'your_password'
]
```

## Features

- Redis-based caching implementation
- Support for cache tags
- Automatic instrumentation for performance tracking
- PSR-16 compliant cache interface

## License

MIT License - see LICENSE file for details 