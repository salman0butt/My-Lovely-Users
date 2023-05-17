<?php

/**
 * This Class responsible for registering the custom route
 *
 * @link       https://github.com/salman0butt
 * @since      1.0.0
 * @package    MyLovelyUsers
 * @subpackage MyLovelyUsers\includes
 * @author     Salman Raza <salman0butt@gmail.com>
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
        add_action('init', [$this, 'registerCustomEndpoint']);
    }

    /**
    * Register the custom endpoint with WordPress.
    *
    * @return void
    */
    public function registerCustomEndpoint(): void
    {
        // Check if the 'my_lovely_users_endpoint' option exists, and use a default value if it doesn't.
        $endpoint = get_option('my_lovely_users_endpoint');
        if (!$endpoint) {
            $endpoint = 'my-lovely-users-table';
        }
        // Register the custom endpoint with WordPress using the add_rewrite_rule() function.
        add_rewrite_rule($endpoint, 'index.php?my_lovely_users_table=1', 'top');
        // Register a rewrite tag to capture the value of the custom endpoint.
        add_rewrite_tag('%my_lovely_users_table%', '1');
        // Flush the rewrite rules to ensure the custom endpoint works correctly.
        flush_rewrite_rules();
    }
}