<?php

/**
 * This class is responsible for registering the custom endpoint with WordPress.
 *
 * @link       https://github.com/salman0butt
 * @since      1.0.0
 * @package    MyLovelyUsers
 * @subpackage MyLovelyUsers\includes
 * @author     Salman Raza
 */

declare(strict_types=1);

namespace Inpsyde\MyLovelyUsers\Includes;

use Inpsyde\MyLovelyUsers\Interfaces\UserTableInterface;
use Exception;
use Inpsyde\MyLovelyUsers\Interfaces\UserTableShortcodeInterface;

class UserTableShortcode implements UserTableShortcodeInterface
{
    /**
     * UserTable instance to render the user table.
     *
     * @var UserTableInterface
     */
    private $userTable;

    /**
     * Constructor.
     *
     * @param UserTableInterface $userTable UserTableInterface instance to render the user table.
     */
    public function __construct(UserTableInterface $userTable)
    {
        $this->userTable = $userTable;
    }

    /**
     * Registers the hooks for plugin settings.
    */
    public function register(): void
    {
        // Register the shortcode
        add_shortcode('my_lovely_user_table', [$this, 'renderUserTable']);
    }

    /**
     * Renders the user table.
     *
     * @param string $atts Shortcode attributes.
     * @return string Rendered user table HTML.
     */
    public function renderUserTable(string $atts): string
    {
        // Render the user table
        ob_start();
        $this->userTable->showUserTable(true);
        return ob_get_clean();
    }
}
