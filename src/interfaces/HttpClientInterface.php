<?php

declare(strict_types=1);

namespace Inpsyde\MyLovelyUsers\Interfaces;

interface HttpClientInterface
{
    public function get(string $key): array;
}
