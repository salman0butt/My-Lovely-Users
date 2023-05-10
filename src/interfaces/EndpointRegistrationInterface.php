<?php

declare(strict_types=1);

namespace Inpsyde\MyLovelyUsers\Interfaces;

interface EndpointRegistrationInterface
{
    public function register(): void;
    public function registerCustomEndpoint(): void;
}
