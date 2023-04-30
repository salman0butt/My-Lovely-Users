<?php

declare(strict_types=1);

namespace Inpsyde\MyLovelyUsers\Interfaces;

interface LoaderInterface
{
    public function addAction(string $hook, array $callback, int $priority = 10, int $acceptedArgs = 1): void;

    public function addFilter(string $hook, array $callback, int $priority = 10, int $acceptedArgs = 1): void;

    public function run(): void;
}
