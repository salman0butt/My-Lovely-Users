<?php

/**
 * Class UserTable
 *
 * This class is responsible for rendering a table of users from UserRendererInterface
 * and fetching users from UserFetcherInterface.
 *
 * @link       https://github.com/salman0butt
 * @since      1.0.0
 * @package    MyLovelyUsers
 * @subpackage MyLovelyUsers\includes
 * @author     Salman Raza
 */

declare(strict_types=1);

namespace Inpsyde\MyLovelyUsers\Includes;

use Inpsyde\MyLovelyUsers\Interfaces\UserFetcherInterface;
use Exception;

use Inpsyde\MyLovelyUsers\Interfaces\UserRendererInterface;
use Inpsyde\MyLovelyUsers\Interfaces\UserTableInterface;

class UserTable implements UserTableInterface
{
    /**
     * UserFetcherInterface instance to fetch users.
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
     * @param UserFetcherInterface $userFetcher   UserFetcherInterface instance to fetch users.
     * @param UserRendererInterface $userRenderer UserRendererInterface instance to render users.
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
     * @throws \Exception If an error occurs during user fetching.
     */
    public function getUsers(): array
    {
        try {
            return $this->userFetcher->fetchUsers();
        } catch (Exception $exp) {
            // Log the error message
            error_log('Error fetching users: ' . $exp->getMessage());
        }

        return [];
    }

    /**
     * Renders a table of users using UserRendererInterface.
     *
     * @throws Exception If an error occurs during user rendering.
     */
    public function render(): void
    {
        try {
            $users = $this->getUsers();

            if (!empty($users)) {
                echo $this->userRenderer->render(compact('users'), 'table');
            } else {
                // When no users found
                throw new Exception('No users found.');
            }
        } catch (Exception $exp) {
            // Log the error message
            error_log('Error rendering user table: ' . $exp->getMessage());
        }
    }
}
