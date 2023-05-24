<?php

/**
 * Interface UserTableInterface
 *
 * Defines the contract for the UserTable class.
 *
 * @link       https://github.com/salman0butt
 * @since      1.0.0
 * @package    MyLovelyUsers
 * @subpackage MyLovelyUsers\includes
 */

declare(strict_types=1);

namespace Inpsyde\MyLovelyUsers\Interfaces;

interface UserTableInterface
{
    /**
     * Registers an action hook to render the user table.
     */
    public function register(): void;

    /**
     * Fetches an array of users using UserFetcherInterface.
     *
     * @return array The fetched users.
     */
    public function fetchUsers(): array;

    /**
     * Renders a table of users using UserRendererInterface.
     */
    public function render(): void;

    /**
     * Renders a table of users using UserRendererInterface.
     * @param bool $isShortcode
     */
    public function showUserTable(bool $isShortcode = false): void;
}
