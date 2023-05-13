<?php
/**
 * Fired during plugin activation
 *
 * This class handles all code necessary to run during the plugin's activation.
 *
 * @link       https://github.com/salman0butt
 * @since      1.0.0
 * @package    MyLovelyUsers
 * @subpackage MyLovelyUsers\includes
 * @author     Salman Raza <salman0butt@gmail.com>
 */

 declare(strict_types=1);

namespace Inpsyde\MyLovelyUsers\Includes;

class MyLovelyUsersActivator
{
    /**
    * Activates the plugin.
    *
    * If the option 'my_lovely_users_endpoint' does not exist, it adds the option with the value
    * of MY_LOVELY_USERS_ENDPOINT. Then, it flushes the rewrite rules.
    *
    * @since 1.0.0
    */
    public static function activate(): void
    {
        // If the option does not exist, add it
        if (!get_option('my_lovely_users_endpoint')) {
            add_option('my_lovely_users_endpoint', MY_LOVELY_USERS_ENDPOINT);
        }
        // Flush rewrite rules on activation
        flush_rewrite_rules();
    }
}
