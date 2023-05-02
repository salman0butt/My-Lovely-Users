<?php

declare(strict_types=1);

namespace Inpsyde\MyLovelyUsers;

use Inpsyde\MyLovelyUsers\Interfaces\CacheInterface;
use Inpsyde\MyLovelyUsers\Interfaces\HttpClientInterface;

class Core
{
    private CacheInterface $cache;
    private HttpClientInterface $httpClient;
    private int $cacheExpireTime = 60 * 60;
    private string $apiUrl = 'https://jsonplaceholder.typicode.com/users';

    public function __construct(CacheInterface $cache, HttpClientInterface $httpClient)
    {
        $this->cache = $cache;
        $this->httpClient = $httpClient;
    }

    public function registerCustomEndpoint(): void
    {
        $endpoint = get_option('my_lovely_users_endpoint');

        if (!$endpoint) {
            $endpoint = 'my-lovely-users-table';
        }

        add_rewrite_rule($endpoint, 'index.php?my_lovely_users_table=1', 'top');
        add_rewrite_tag('%my_lovely_users_table%', '1');
        // clear the rewrite to make the endpoint working without issue
        flush_rewrite_rules();
    }

    public function showUsersTable(): void
    {

        if (!get_query_var('my_lovely_users_table')) {
            return;
        }

        $users = $this->fetchUsersData();
        $this->renderUsersTable($users);
        exit;
    }

    private function renderUsersTable(array $users): void
    {
        require_once dirname(__DIR__) . '/src/partials/users-table.php';
    }

    // fetchUsersData call http request to get users data
    public function fetchUsersData(): ?array
    {

        // Check if data is in cache
        $cachedUsersData = $this->cache ? $this->cache->get('my_lovely_users_data') : null;

        if ($cachedUsersData) {
            return $cachedUsersData;
        }

        $users = [];

        try {
            $users = $this->httpClient->get($this->apiUrl);
        } catch (\Exception $exp) {
            wp_send_json_error("Error fetching users data: " . $exp->getMessage());
        }

        // Cache data for 1 hour
        if ($this->cache) {
            $this->cache->set('my_lovely_users_data', $users, $this->cacheExpireTime);
        }

        return $users;
    }

    // fetchUserDetailsCallback is called by ajax
    public function fetchUserDetailsCallback(): mixed
    {
        $userId = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;

        if (! $userId) {
            wp_send_json_error("Invalid user ID.");
        }

        $myPluginNonce = isset($_POST['my_plugin_nonce'])
        ? sanitize_text_field(wp_unslash($_POST['my_plugin_nonce']))
        : '';

          // Verify nonce
        if (
            !isset($myPluginNonce)
            || !wp_verify_nonce($myPluginNonce, 'my_lovely_user_nonce')
        ) {
            wp_send_json_error("Security check failed.");
        }

        // Check if data is in cache
        $cachedUserData = $this->cache
        ? $this->cache->get('my_lovely_users_data_detail_' . $userId)
        : null;

        if ($cachedUserData) {
            wp_send_json_success(['html' => $cachedUserData]);
        }
        $userDetails = null;
        try {
            $userDetails = $this->httpClient->get($this->apiUrl . "/{$userId}");
        } catch (\Exception $exp) {
            wp_send_json_error("Error fetching users data: " . $exp->getMessage());
        }

        $output = $this->rednerUserDetails($userDetails);

        // Cache data for 1 hour
        if ($userDetails) {
            $this
            ->cache
            ->set('my_lovely_users_data_detail_' . $userId, $output, $this->cacheExpireTime);
        }

        return wp_send_json_success([
            'html' => $output,
        ]);
    }

    private function rednerUserDetails(array $userDetails): string
    {
        ob_start();
        require_once  dirname(__DIR__) . '/src/partials/users-detail.php';
        return ob_get_clean();
    }

    public function myLovelyUsersSettingsPage()
    {

        add_options_page(
            'My Lovely Users Settings',
            'My Lovely Users',
            'manage_options',
            'my_lovely_users_settings',
            [$this, 'myLovelyUsersSettingsPageCallback']
        );
    }

    public function myLovelyUsersSettingsPageCallback()
    {

        ?>
        <div class="wrap">
            <h1>My Lovely Users Settings</h1>
            <form method="post" action="options.php">
                <?php settings_fields('my_lovely_users_settings'); ?>
                <?php do_settings_sections('my_lovely_users_settings'); ?>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">Endpoint URL</th>
                        <td>
                            <input 
                            type="text" 
                            name="my_lovely_users_endpoint" 
                            value="<?php echo esc_attr(get_option('my_lovely_users_endpoint')); ?>"
                            >
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }

    public function myLovelyUsersSaveSettings()
    {

        register_setting('my_lovely_users_settings', 'my_lovely_users_endpoint');
    }
}
