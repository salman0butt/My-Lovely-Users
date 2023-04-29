<?php

declare(strict_types=1);

namespace Inpsyde\MyLovelyUsers;

use Inpsyde\MyLovelyUsers\Interfaces\CacheSystemInterface;

class MyCache implements CacheSystemInterface
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
