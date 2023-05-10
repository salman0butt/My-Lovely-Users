<?php

declare (strict_types = 1);

namespace Inpsyde\MyLovelyUsers;

use Inpsyde\MyLovelyUsers\Interfaces\CacheInterface;
use Inpsyde\MyLovelyUsers\Interfaces\HttpClientInterface;

class UserDetails
{
    private CacheInterface $cache;
    private HttpClientInterface $httpClient;
    private int $cacheExpireTime;
    private const USER_DETAILS_CACHE_PREFIX = 'my_lovely_users_data_detail_';

    public function __construct(CacheInterface $cache, HttpClientInterface $httpClient, int $cacheExpireTime = 3600)
    {
        $this->cache = $cache;
        $this->httpClient = $httpClient;
        $this->cacheExpireTime = $cacheExpireTime;
    }

    public function register(): void {
        add_action('wp_ajax_fetch_user_details', [$this, 'handleAjaxRequest']);
        add_action(
            'wp_ajax_nopriv_fetch_user_details',
            [$this, 'handleAjaxRequest']
        );
    }

    private function getUser(int $userId): array
    {
        $cacheKey = self::USER_DETAILS_CACHE_PREFIX . $userId;
        $user = $this->cache->get($cacheKey);

        if (!$user) {
            try {
                $response = $this->httpClient->get("https://jsonplaceholder.typicode.com/users/$userId");
                $user = $response['data'];
                $this->cache->set($cacheKey, $user, $response['ttl']);
            } catch (\Exception $exception) {
                // handle error
                throw $exception;
            }
        }

        return $user;
    }

    public function handleAjaxRequest(): void
    {
        $userId = isset($_POST['user_id']) ? absint(wp_unslash($_POST['user_id'])) : 0;

        if (!$userId || !is_int($userId)) {
            wp_send_json_error("Invalid user ID.");
            return;
        }

        $nonce = $_POST['my_plugin_nonce'] ?? '';
        $nonceVerified = $this->verifyNonce($nonce);

        if (!$nonceVerified) {
            wp_send_json_error('Security check failed.');
            return;
        }

        // Check if data is in cache
        $cachedUserData = $this->cache->get(self::USER_DETAILS_CACHE_PREFIX . $userId);

        if ($cachedUserData) {
            wp_send_json_success(['html' => $cachedUserData]);
            return;
        }

        try {
            $userDetails = $this->getUser($userId);
            $output = $this->getUserDetailsTemplate($userDetails);

            // Cache data for 1 hour
            if ($userDetails) {
                $this->cache->set(
                    self::USER_DETAILS_CACHE_PREFIX . $userId,
                    $output,
                    $this->cacheExpireTime
                );
            }

            wp_send_json_success([
                'html' => $output,
            ]);
        } catch (\Exception $exp) {
            wp_send_json_error("Error fetching user's data: " . $exp->getMessage());
            return;
        }
    }

    private function getUserDetailsTemplate(array $userDetails): string
    {
        ob_start();
        require_once dirname(__DIR__) . '/src/partials/users-detail.php';
        return (string) ob_get_clean();
    }

    private function verifyNonce(string $nonce): bool
    {
        return isset($nonce) && wp_verify_nonce($nonce, 'my_lovely_user_nonce');
    }

}
