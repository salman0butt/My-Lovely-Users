<?php

declare(strict_types=1);

namespace Inpsyde\MyLovelyUsers\Interfaces;

interface AssetInterface
{
    public function __construct(string $pluginName, string $version);
    public function enqueueStyles(): void;
    public function enqueueScripts(): void;
}
