<?php

declare (strict_types = 1);

namespace Inpsyde\MyLovelyUsers;

use Inpsyde\MyLovelyUsers\Interfaces\CacheInterface;
use Inpsyde\MyLovelyUsers\Interfaces\HttpClientInterface;

class UsersTable
{
    private CacheInterface $cache;
    private HttpClientInterface $httpClient;
    private int $cacheExpireTime;
    private const USER_CACHE_PREFIX = 'my_lovely_users_data';
    private $apiUrl = 'https://jsonplaceholder.typicode.com/users';

    public function __construct(CacheInterface $cache, HttpClientInterface $httpClient, int $cacheExpireTime = 3600)
    {
        $this->cache = $cache;
        $this->httpClient = $httpClient;
        $this->cacheExpireTime = $cacheExpireTime;
    }

    public function register(): void {
        add_action('template_redirect', [$this, 'render']);
    }

    public function render(): ?string
    {
        if (!get_query_var('my_lovely_users_table')) return;

        $users = $this->getUsers();
        // render the users table
        $html ='<h3 style="text-align:center; margin-bottom: 10px !important;">'.esc_html__('My Lovely Users Table', 'my-lovely-users').'</h3>
        <div class="table-container">';
        $html .= '<table id="users-table">';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th>ID</th>';
        $html .= '<th>Name</th>';
        $html .= '<th>Username</th>';
        $html .= '<th>Email</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';

        if ($users && count($users) > 0) {
            foreach ($users as $user) {
                $html .= '<tr>';
                $html .= '<td>';
                $html .= '<a href="#" class="user-details-link" data-user-id="' . (isset($user['id']) ? esc_attr($user['id']) : '') . '">';
                $html .= isset($user['id']) ? esc_html($user['id']) : '';
                $html .= '</a>';
                $html .= '</td>';
                $html .= '<td>';
                $html .= '<a href="#" class="user-details-link" data-user-id="' . (isset($user['id']) ? esc_attr($user['id']) : '') . '">';
                $html .= isset($user['name']) ? esc_html($user['name']) : '';
                $html .= '</a>';
                $html .= '</td>';
                $html .= '<td>';
                $html .= '<a href="#" class="user-details-link" data-user-id="' . (isset($user['id']) ? esc_attr($user['id']) : '') . '">';
                $html .= isset($user['username']) ? esc_html($user['username']) : '';
                $html .= '</a>';
                $html .= '</td>';
                $html .= '<td>';
                $html .= '<a href="#" class="user-details-link" data-user-id="' . (isset($user['id']) ? esc_attr($user['id']) : '') . '">';
                $html .= isset($user['email']) ? esc_html($user['email']) : '';
                $html .= '</a>';
                $html .= '</td>';
                $html .= '</tr>';
            }
        }

        $html .= '</tbody>';
        $html .= '</table>';
        $html .= '</div>';
        return $html;
    }

    private function getUsers(): array 
    {
        $cacheKey = self::USER_CACHE_PREFIX;
        $users = $this->cache->get($cacheKey);

        if (!$users) {
            try {
                $response = $this->httpClient->get($this->apiUrl);
                $users = $response['data'];
                $this->cache->set($cacheKey, $users, $this->cacheExpireTime);
            } catch (\Exception $exception) {
                // handle error
                throw $exception;
            }
        }

        return $users;
    }
}
