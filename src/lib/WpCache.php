<?php

declare(strict_types=1);

namespace Inpsyde\MyLovelyUsers\Lib;

use Inpsyde\MyLovelyUsers\Interfaces\CacheInterface;

/**
 * Class WpCache
 *
 * WordPress implementation of the CacheInterface.
 */
class WpCache implements CacheInterface
{
    /**
     * Retrieves a value from the cache.
     *
     * @param string $key The cache key.
     *
     * @return mixed|null The cached value or null if not found.
     */
    public function get(string $key): mixed
    {
        return get_transient($key);
    }

    /**
     * Sets a value in the cache.
     *
     * @param string $key        The cache key.
     * @param mixed  $value      The value to cache.
     * @param int    $expiration The expiration time in seconds.
     *
     * @return void
     */
    public function set(string $key, mixed $value, int $expiration): void
    {
        set_transient($key, $value, $expiration);
    }
}
