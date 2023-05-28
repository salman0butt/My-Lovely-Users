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

use Exception;
use Inpsyde\MyLovelyUsers\Exceptions\UserRendererException;
use Inpsyde\MyLovelyUsers\Exceptions\UserFetcherException;
use Inpsyde\MyLovelyUsers\Exceptions\UserTableException;
use Inpsyde\MyLovelyUsers\Interfaces\LoggerInterface;
use Inpsyde\MyLovelyUsers\Interfaces\UserFetcherInterface;
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
     * The logger to log
     *
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * Constructor.
     *
     * @param UserFetcherInterface $userFetcher   UserFetcherInterface instance to fetch users.
     * @param UserRendererInterface $userRenderer UserRendererInterface instance to render users.
     * @param LoggerInterface $logger LoggerInterface instance to log.
     */
    public function __construct(
        UserFetcherInterface $userFetcher,
        UserRendererInterface $userRenderer,
        LoggerInterface $logger
    ) {

        $this->userFetcher = $userFetcher;
        $this->userRenderer = $userRenderer;
        $this->logger = $logger;
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
     * @throws UserFetcherException If an error occurs during user fetching.
     */
    public function fetchUsers(): array
    {
        try {
            return $this->userFetcher->fetchUsers();
        } catch (UserFetcherException $exception) {
            $errorMessage = 'An error occurred during user fetching: ' . $exception->getMessage();
            $this->logger->logError($errorMessage);
            throw $exception;
        } catch (Exception $exception) {
            $errorMessage = 'An unexpected error occurred: ' . $exception->getMessage();
            $this->logger->logError($errorMessage);
            throw new UserFetcherException($errorMessage);
        }
    }

    /**
     * Renders a table of users using UserRendererInterface.
     *
     * @throws UserTableException If an error occurs during user rendering.
     */
    public function render(): void
    {

        try {
            $renderTable = get_query_var('my_lovely_users_table');
            if ($renderTable) {
                $this->showUserTable();
            }
        } catch (UserTableException $exception) {
            $this->logger->logError('Failed to render users table: ' . $exception->getMessage());
            throw $exception;
        } catch (Exception $exception) {
            $this->logger->logError('Failed to render users table: ' . $exception->getMessage());
            throw new UserTableException('An unexpected error Failed to render users table.');
        }
    }

    /**
     * Renders the user table.
     *
     * @param bool $isShortcode
     * @throws UserFetcherException If an error occurs during user rendering.
     */
    public function showUserTable(bool $isShortcode = false): void
    {
        try {
            $users = $this->fetchUsers();

            if (empty($users)) {
                throw new UserFetcherException('No users found.');
            }

            // Rendered users data
            $usersData = $this->userRenderer->renderUsersTable($users);

            // Show users table
            if ($isShortcode) {
                echo wp_kses_post($usersData);
                return;
            }

            // pass data using filter
            add_filter('my_lovely_users_template_data', static function () use ($usersData) {
                return $usersData;
            });

            // Render the template
            $this->renderTemplate();
        } catch (UserFetcherException $exception) {
            // Log the error message
            $this->logger->logError('Failed to fetch users data: ' . $exception->getMessage());
            throw new UserTableException('Failed to fetch users data: ' . $exception->getMessage());
        } catch (UserRendererException $exception) {
            // Log the error message
            $errMessage = 'Failed to fetch users data: ' . $exception->getMessage();
            $this->logger->logError($errMessage);
            throw new UserTableException($errMessage);
        } catch (Exception $exception) {
            // Log the error message
            $this->logger->logError('An error occurred: ' . $exception->getMessage());
            throw new UserTableException('An error occurred during user rendering.');
        }
    }

    private function renderTemplate(): void
    {
        $template = 'users-table-page.php';

        // Locate the template file using WordPress template hierarchy
        $templatePath = locate_template($template);

        // If the template file doesn't exist in the theme, use the plugin's template
        if (empty($templatePath)) {
            $templatePath = plugin_dir_path(__FILE__) . '../templates/' . $template;
        }

        if (!empty($templatePath)) {
            include $templatePath;
        }
    }
}
