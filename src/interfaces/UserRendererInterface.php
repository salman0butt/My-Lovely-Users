<?php

/**
 * Interface for rendering users
 *
 */

declare(strict_types=1);

namespace Inpsyde\MyLovelyUsers\Interfaces;

interface UserRendererInterface
{
    /**
     * Renders an array of user data as an HTML string.
     *
     * @param array $users An array of users data to render.
     * @return string The rendered HTML string.
     */
    public function renderUsersTable(array $users): string;

    /**
     * Renders an array of user data as an HTML string.
     *
     * @param array $user An array of user data to render.
     * @return string The rendered HTML string.
     */
    public function renderUserDetail(array $users): string;
}
