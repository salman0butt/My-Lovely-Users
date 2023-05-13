<?php

/**
 * CacheInterface represents an interface for a cache implementation.
*/

declare(strict_types=1);

namespace Inpsyde\MyLovelyUsers\Interfaces;

interface CacheInterface
{
    /**
     * Retrieve a value from the cache.
     *
     * @param string $key The cache key to retrieve.
     * @return mixed The cached value, or null if not found.
     */
    public function get(string $key): mixed;

     /**
     * Set a value in the cache.
     *
     * @param string $key The cache key to set.
     * @param mixed $value The value to cache.
     * @param int $expiration The time, in seconds, until the cache should expire.
     */
    public function set(string $key, mixed $value, int $expiration): mixed;
}
