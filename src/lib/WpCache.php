<?php

declare(strict_types=1);

namespace Inpsyde\MyLovelyUsers\Lib;

use Inpsyde\MyLovelyUsers\Interfaces\CacheInterface;

class WpCache implements CacheInterface
{
    public function get(string $key): mixed
    {
        return get_transient($key);
    }

    public function set(string $key, mixed $value, int $expiration): void
    {
        set_transient($key, $value, $expiration);
    }
}
