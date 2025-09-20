<?php

/*
 * This file is part of WebFramework.
 *
 * (c) Avoutic <avoutic@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WebFramework\Redis;

use Carbon\Carbon;
use WebFramework\Diagnostics\Instrumentation;
use WebFramework\Queue\Job;
use WebFramework\Queue\Queue;

class RedisQueue implements Queue
{
    public function __construct(
        private Instrumentation $instrumentation,
        private \Redis $redis,
        private string $name,
    ) {}

    public function dispatch(Job $job, int $delay = 0): void
    {
        $span = $this->instrumentation->startSpan('queue.dispatch');

        $queueKey = "queue:{$this->name}";
        $data = serialize($job);

        if ($delay > 0)
        {
            $this->redis->zAdd("queue:{$this->name}:delayed", Carbon::now()->addSeconds($delay)->getTimestamp(), $data);
        }
        else
        {
            $this->redis->lPush($queueKey, $data);
        }

        $this->instrumentation->finishSpan($span);
    }

    public function count(): int
    {
        $span = $this->instrumentation->startSpan('queue.count');

        $queueKey = "queue:{$this->name}";
        $count = $this->redis->lLen($queueKey);

        $this->instrumentation->finishSpan($span);

        return $count;
    }

    public function popJob(): ?Job
    {
        $span = $this->instrumentation->startSpan('queue.pop');

        $queueKey = "queue:{$this->name}";
        $data = $this->redis->rPop($queueKey);

        if ($data === false)
        {
            $this->instrumentation->finishSpan($span);

            return null;
        }

        $job = unserialize($data);
        $this->instrumentation->finishSpan($span);

        return $job;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function clear(): void
    {
        $span = $this->instrumentation->startSpan('queue.clear');

        $queueKey = "queue:{$this->name}";
        $this->redis->del($queueKey);
        $this->redis->del("queue:{$this->name}:delayed");

        $this->instrumentation->finishSpan($span);
    }
}
