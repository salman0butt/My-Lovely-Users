<?php

/**
 * Class UsersRenderer
 *
 * This class is responsible for rendering a table of users.
 *
 * @link       https://github.com/salman0butt
 * @since      1.0.0
 * @package    MyLovelyUsers
 * @subpackage MyLovelyUsers\includes
 * @author     Salman Raza <salman0butt@gmail.com>
 */

declare(strict_types=1);

namespace Inpsyde\MyLovelyUsers\Includes;

use Inpsyde\MyLovelyUsers\Interfaces\UserRendererInterface;

class UsersRenderer implements UserRendererInterface
{
    /**
     * Render a table of users.
     *
     * @param array $users An array of user data.
     *
     * @return string The HTML for the rendered table.
     */
    public function render(array $users): string
    {
        ob_start();
        require_once plugin_dir_path(__FILE__) . '/templates/users-table.php';
        return ob_get_clean();
    }
}
