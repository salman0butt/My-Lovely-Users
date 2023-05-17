<?php

/**
 * Class UserTable
 *
 * This class is responsible for rendering a table of users from UserRendererInterface
 * and fetching users from UserFetcherInterface
 *
 * @link       https://github.com/salman0butt
 * @since      1.0.0
 * @package    MyLovelyUsers
 * @subpackage MyLovelyUsers\includes
 * @author     Salman Raza <salman0butt@gmail.com>
 */

declare(strict_types=1);

namespace Inpsyde\MyLovelyUsers\Includes;

use Inpsyde\MyLovelyUsers\Interfaces\UserFetcherInterface;
use Inpsyde\MyLovelyUsers\Interfaces\UserTableInterface;

use Inpsyde\MyLovelyUsers\Interfaces\UserRendererInterface;

class UserTable implements UserTableInterface
{
    /**
     * UserFetcherInterface instance to fetch users
     *
     * @var UserFetcherInterface
     */
    private UserFetcherInterface $userFetcher;
    /**
     * UserRendererInterface instance to render users.
     *
     * @var UserRendererInterface
     */
    private UserRendererInterface $userRenderer;
    /**
     * Constructor.
     *
     * @param UserFetcherInterface $userFetcher    UserFetcherInterface instance to fetch users.
     * @param UserRendererInterface $userRenderer  UserRendererInterface instance to render users.
     */
    public function __construct(UserFetcherInterface $userFetcher, UserRendererInterface $userRenderer)
    {
        $this->userFetcher = $userFetcher;
        $this->userRenderer = $userRenderer;
    }

    /**
     * Registers an action hook to render the user table.
     */
    public function register(): void
    {
        add_action('template_redirect', [$this, 'render']);
    }

    /**
     * Fetches an array of users using UserFetcherInterface.
     *
     * @return array The fetched users.
     */
    public function getUsers(): array
    {
        return $this->userFetcher->fetchUsers();
    }

    /**
     * Renders a table of users using UserRendererInterface.
     *
     * @return string The rendered user table.
     */
    public function render(): void
    {
        $users = $this->getUsers();
        echo $this->userRenderer->render($users);
        return;
    }
}
