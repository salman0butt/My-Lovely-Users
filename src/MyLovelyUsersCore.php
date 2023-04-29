<?php

declare(strict_types=1);

namespace Inpsyde\MyLovelyUsers;

use Inpsyde\MyLovelyUsers\MyCache;

class MyLovelyUsersCore
{
    private MyCache $cache;
    private $cacheExpireTime = 60 * 60;
    private string $apiUrl = 'https://jsonplaceholder.typicode.com/users';

    public function __construct(MyCache $cache)
    {

        $this->cache = $cache;
    }

    public function registerCustomEndpoint(): void
    {
        add_rewrite_rule('my-lovely-users-table/?$', 'index.php?my_lovely_users_table=1', 'top');
        add_rewrite_tag('%my_lovely_users_table%', '1');
    }

    public function displayUsersTable(): void
    {
        if (get_query_var('my_lovely_users_table')) {
            $users = $this->fetchUsersData();

            ob_start();
            include  plugin_dir_path(__FILE__) . 'assets/partials/users-table.php';
            // phpcs:disable
            echo ob_get_clean();
            exit;
        }
    }

    private function fetchUsersData(): array
    {

        // Check if data is in cache
        $cachedUsersData = $this->cache->get('my_lovely_users_data');

        if ($cachedUsersData) {
            // Data was found in cache, return it
            return $cachedUsersData;
        }

        $response = wp_remote_get($this->apiUrl);

        if (is_wp_error($response)) {
            // Handle WP_Error
            $errorMessage = $response->get_error_message();
            wp_send_json_error("Error fetching users data: $errorMessage");
        }

        $statusCode = wp_remote_retrieve_response_code($response);

        if ($statusCode !== 200) {
            // Handle non-200 HTTP response codes
            wp_send_json_error("Error fetching users data");
        }

        $body = wp_remote_retrieve_body($response);

        if (!$body) {
            // Handle empty response body
            wp_send_json_error("Error fetching users data: Response body is empty");
        }

        $users = json_decode($body, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            // Handle JSON decoding errors
            wp_send_json_error("Error decoding users data JSON: " . json_last_error_msg());
        }

        // Cache data for 1 hour
        if ($users && count($users) > 0) {
            $this->cache->set( 'my_lovely_users_data', $users, $this->cacheExpireTime );
        }

        return $users;
    }

    public function fetchUserDetailsCallback(): void
    {
        $userId = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;

        if (! $userId) {
            wp_send_json_error('Invalid user ID.');
        }
        $myPluginNonce = $_POST['my_plugin_nonce'] ?? '';
        $myPluginNonce = sanitize_text_field(wp_unslash($myPluginNonce));

          // Verify nonce
        if (
            !isset($myPluginNonce)
            || !wp_verify_nonce($myPluginNonce, 'my_lovely_user_nonce')
        ) {
            wp_send_json_error('Security check failed.');
        }

        // Check if data is in cache
        $cachedUserData = $this->cache->get('my_lovely_users_data_detail_' . $userId);

        if ($cachedUserData) {
            // Data was found in cache, return it
            wp_send_json_success(['html' => $cachedUserData]);
        }

        $url = $this->apiUrl . "/{$userId}";
        $response = wp_remote_get($url);
        if (is_wp_error($response)) {
            wp_send_json_error('Failed to fetch user details.');
        }

        $body = wp_remote_retrieve_body($response);
        if (! $body) {
            wp_send_json_error('Failed to fetch user details.');
        }

        $userDetails = json_decode($body, true);

        ob_start();
        include  plugin_dir_path(__FILE__) . 'assets/partials/users-detail.php';
        $output = ob_get_clean();

        // Cache data for 1 hour
        if ($userDetails) {
            $this->cache->set('my_lovely_users_data_detail_' . $userId, $output, $this->cacheExpireTime);
        }

        wp_send_json_success(['html' => $output]);
    }
}
