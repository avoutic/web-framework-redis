<?php

namespace WebFramework\Redis;

use Cache\Adapter\Redis\RedisCachePool;
use Psr\Container\ContainerInterface;
use WebFramework\Security\ConfigService;

return [
    RedisCachePool::class => function (ContainerInterface $c) {
        $secureConfigService = $c->get(ConfigService::class);

        $cacheConfig = $secureConfigService->getAuthConfig('redis');

        $redisClient = new \Redis();

        $result = $redisClient->pconnect(
            $cacheConfig['hostname'],
            $cacheConfig['port'],
            1,
            'wf',
            0,
            0,
            ['auth' => $cacheConfig['password']]
        );

        if ($result !== true)
        {
            throw new \RuntimeException('Redis Cache connection failed');
        }

        return new RedisCachePool($redisClient);
    },
];
