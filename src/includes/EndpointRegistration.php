<?php

/**
 * This class is responsible for registering the custom endpoint with WordPress.
 *
 * @link       https://github.com/salman0butt
 * @since      1.0.0
 * @package    MyLovelyUsers
 * @subpackage MyLovelyUsers\includes
 * @author     Salman Raza
 */

declare(strict_types=1);

namespace Inpsyde\MyLovelyUsers\Includes;

use Inpsyde\MyLovelyUsers\Interfaces\EndpointRegistrationInterface;

class EndpointRegistration implements EndpointRegistrationInterface
{
    /**
     * Register the custom endpoint hook.
     *
     * @return void
     */
    public function register(): void
    {
        // Register the custom endpoint during WordPress initialization.
        add_action('init', [$this, 'registerCustomEndpoint']);
    }

    /**
     * Register the custom endpoint with WordPress.
     *
     * @return void
     */
    public function registerCustomEndpoint(): void
    {
        $endpoint = $this->getEndpointOption();

        if (!$endpoint) {
            $endpoint = 'my-lovely-users-table';
        }

        $endpoint = $this->sanitizeEndpoint($endpoint);

        $this->addRewriteRule($endpoint);
        $this->addRewriteTag();
        $this->flushRewriteRules();
    }

    /**
     * Retrieve the value of the 'my_lovely_users_endpoint' option.
     *
     * @return string|null The endpoint value.
     */
    private function getEndpointOption(): ?string
    {
        return get_option('my_lovely_users_endpoint');
    }

    /**
     * Sanitize the endpoint value to ensure it contains only valid characters.
     *
     * @param string $endpoint The endpoint value.
     * @return string The sanitized endpoint value.
     */
    private function sanitizeEndpoint(string $endpoint): string
    {
        return sanitize_text_field($endpoint);
    }

    /**
     * Register the custom endpoint with WordPress using the add_rewrite_rule() function.
     *
     * @param string $endpoint The endpoint value.
     * @return void
     */
    private function addRewriteRule(string $endpoint): void
    {
        add_rewrite_rule($endpoint, 'index.php?my_lovely_users_table=1', 'top');
    }

    /**
     * Register a rewrite tag to capture the value of the custom endpoint.
     *
     * @return void
     */
    private function addRewriteTag(): void
    {
        add_rewrite_tag('%my_lovely_users_table%', '1');
    }

    /**
     * Flush the rewrite rules to ensure the custom endpoint works correctly.
     *
     * @return void
     */
    private function flushRewriteRules(): void
    {
        flush_rewrite_rules();
    }
}
