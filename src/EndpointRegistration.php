<?php

declare(strict_types=1);

namespace Inpsyde\MyLovelyUsers;

use Inpsyde\MyLovelyUsers\Interfaces\EndpointRegistrationInterface;


class EndpointRegistration implements EndpointRegistrationInterface
{
    public function register(): void
    {
        add_action('init', [$this, 'registerCustomEndpoint']);
    }

    public function registerCustomEndpoint(): void
    {
        // register custom endpoint
        $endpoint = get_option('my_lovely_users_endpoint');

        if (!$endpoint) {
            $endpoint = 'my-lovely-users-table';
        }

        add_rewrite_rule($endpoint, 'index.php?my_lovely_users_table=1', 'top');
        add_rewrite_tag('%my_lovely_users_table%', '1');
        // clear the rewrite to make the endpoint working without issue
        flush_rewrite_rules();
    }
}