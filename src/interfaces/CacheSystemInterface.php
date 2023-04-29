<?php

declare(strict_types=1);

namespace Inpsyde\MyLovelyUsers\Interfaces;

interface CacheSystemInterface
{
    public function get(string $key);
    public function set(string $key, mixed $value, int $expiration);
}
