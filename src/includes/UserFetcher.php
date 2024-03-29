<?php

/**
 * The UserFetcher class fetches user data from a given API URL and caches
 * the results for a specified period of time.
 *
 * @link       https://github.com/salman0butt
 * @since      1.0.0
 * @package    MyLovelyUsers
 * @subpackage MyLovelyUsers\includes
 * @author     Salman Raza <salman0butt@gmail.com>
 */

// Use strict types to ensure type safety
declare(strict_types=1);

namespace Inpsyde\MyLovelyUsers\Includes;

use Inpsyde\MyLovelyUsers\Exceptions\HttpClientException;
use Inpsyde\MyLovelyUsers\Exceptions\UserFetcherException;
use Inpsyde\MyLovelyUsers\Interfaces\CacheInterface;
use Inpsyde\MyLovelyUsers\Interfaces\HttpClientInterface;
use Inpsyde\MyLovelyUsers\Interfaces\LoggerInterface;
use Inpsyde\MyLovelyUsers\Interfaces\UserFetcherInterface;

class UserFetcher implements UserFetcherInterface
{
    /**
     * The cache service used to store the fetched user data.
     *
     * @var CacheInterface
     */
    private CacheInterface $cache;

    /**
     * The HTTP client used to make requests to the API.
     *
     * @var HttpClientInterface
     */
    private HttpClientInterface $httpClient;

    /**
     * The logger to log
     *
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * The amount of time in seconds for which to cache the fetched user data.
     *
     * @var int
     */
    private int $cacheExpireTime;

    /**
     * The prefix used to generate cache keys for users data
     *
     * @var string
     */
    private const USER_CACHE_PREFIX = 'my_lovely_users_data';

    /**
     * The prefix used to generate cache keys for single User data
     *
     * @var string
     */
    private const USER_DETAILS_CACHE_PREFIX = 'my_lovely_users_data_detail_';
    /**
     * The URL of the API to fetch user data from.
     *
     * @var string
     */
    private string $apiUrl;

    /**
     * Constructs a new UserFetcher instance.
     *
     * @param CacheInterface $cache The cache service used to store the fetched user data.
     * @param HttpClientInterface $httpClient The HTTP client used to make requests to the API.
     * @param LoggerInterface $logger The Logger to log.
     * @param int $cacheExpireTime The amount of time in seconds for which to
     * cache the fetched user data. default value is 3600.
     * @param string $apiUrl The URL of the API to fetch user data from. default apiUrl set
     */
    public function __construct(
        CacheInterface $cache,
        HttpClientInterface $httpClient,
        LoggerInterface $logger,
        int $cacheExpireTime = 3600,
        string $apiUrl = 'https://jsonplaceholder.typicode.com/users'
    ) {

        $this->httpClient = $httpClient;
        $this->cache = $cache;
        $this->logger = $logger;
        $this->cacheExpireTime = $cacheExpireTime;
        $this->apiUrl = $apiUrl;
    }

    /**
     * Fetches the user data from the API or from the cache if available.
     *
     * @return array The fetched user data.
     * @throws UserFetcherException If an error occurs while fetching user data.
     */
    public function fetchUsers(): array
    {
        $cacheKey = self::USER_CACHE_PREFIX;
        $users = $this->cache->get($cacheKey);

        if (!$users) {
            try {
                $users = $this->httpClient->get($this->apiUrl);
                $this->cache->set($cacheKey, $users, $this->cacheExpireTime);
            } catch (HttpClientException $exp) {
                // Log the error message with additional details
                $errMessage = "Failed to fetching data from the API: " . $exp->getMessage();
                $this->logger->logError($errMessage);
                throw new UserFetcherException($errMessage);
            }
        }

        return $users;
    }

    /**
     * Fetches the single user data from the API or from the cache if available.
     *
     * @param int $userId The ID of the user to fetch.
     * @return array The fetched user data.
     * @throws UserFetcherException If an error occurs while fetching user data.
     */
    public function fetchUser(int $userId): array
    {
        $cacheKey = self::USER_DETAILS_CACHE_PREFIX . $userId;
        $user = $this->cache->get($cacheKey);

        if (!$user) {
            try {
                $user = $this->httpClient->get($this->apiUrl . "/" . $userId);
                $this->cache->set($cacheKey, $user, $this->cacheExpireTime);
            } catch (HttpClientException $exception) {
                // Log the error message with additional details
                $errMessage = "Failed to fetch user data from API." . $exception->getMessage();
                $this->logger->logError($errMessage);
                // If caching fails, it should not propagate the exception but continue without caching the data
                throw new UserFetcherException($errMessage);
            }
        }

        return $user;
    }
}
