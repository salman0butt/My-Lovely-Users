<?php
/**
* Interface for fetching users.
*
*/

declare(strict_types=1);

namespace Inpsyde\MyLovelyUsers\Interfaces;

interface UserFetcherInterface
{
    /**
     * Fetches all users.
     *
     * @return array An array of users.
     */
    public function fetchUsers(): array;
    
    /**
     * Fetches a single user by ID.
     *
     * @param int $userId The ID of the user to fetch.
     *
     * @return array The user data.
     */
    public function fetchUser(int $userId): array;
}
