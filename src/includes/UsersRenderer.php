<?php

/**
 * Class UsersRenderer
 *
 * This class is responsible for rendering a table of users.
 *
 * @since      1.0.0
 * @package    MyLovelyUsers
 * @subpackage MyLovelyUsers\includes
 */

declare(strict_types=1);

namespace Inpsyde\MyLovelyUsers\Includes;

use Inpsyde\MyLovelyUsers\Interfaces\UserRendererInterface;
use RuntimeException;

class UsersRenderer implements UserRendererInterface
{
    /**
     * Render a table of users.
     *
     * @param array  $users An array of users data.
     *
     * @return string The HTML for the rendered table.
     * @throws RuntimeException If an invalid rendering type is provided or the template file
     * cannot be found or included.
     */
    public function renderUsersTable(array $users): string
    {
        $templatePath = plugin_dir_path(__FILE__) . '/templates/users-table.php';

        if (!file_exists($templatePath)) {
            throw new RuntimeException('Template file not found.');
        }

        ob_start();
        include $templatePath;
        return ob_get_clean();
    }

    /**
     * Render a User Detail
     *
     * @param array  $user An array of user data.
     *
     * @return string The HTML for the rendered table.
     * @throws RuntimeException If an invalid rendering type is provided or the template file
     * cannot be found or included.
     */
    public function renderUserDetail(array $user): string
    {
        $templatePath = plugin_dir_path(__FILE__) . '/templates/users-detail.php';

        if (!file_exists($templatePath)) {
            throw new RuntimeException('Template file not found.');
        }

        ob_start();
        include $templatePath;
        return ob_get_clean();
    }
}
