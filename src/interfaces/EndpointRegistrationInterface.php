<?php

/**
 * Interface for endpoint registration classes.
*/

declare(strict_types=1);

namespace Inpsyde\MyLovelyUsers\Interfaces;

interface EndpointRegistrationInterface
{
    /**
     * Registers all the hooks for endpoint
     *
     * @return void
     */
    public function register(): void;

    /**
     * Registers a custom endpoint for the plugin.
     *
     * @return void
     */
    public function registerCustomEndpoint(): void;
}
