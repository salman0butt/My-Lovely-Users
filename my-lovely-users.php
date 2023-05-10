<?php

declare(strict_types=1);

use Inpsyde\MyLovelyUsers\Setting;
use Inpsyde\MyLovelyUsers\UsersTable;
use Inpsyde\MyLovelyUsers\MyLovelyUsers;
use Inpsyde\MyLovelyUsers\EndpointRegistration;
use Inpsyde\MyLovelyUsers\MyLovelyUsersActivator;
use Inpsyde\MyLovelyUsers\MyLovelyUsersDeactivator;
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/salman0butt
 * @since             1.0.0
 * @package           MyLovelyUsers
 *
 * @wordpress-plugin
 * Plugin Name:       My Lovely Users
 * Plugin URI:        https://example.com/my-lovely-users-table/
 * Description:       A WordPress plugin that shows a table of users with details fetched from a third-party API endpoint.
 * Version:           1.0.0
 * Author:            Salman Raza
 * Author URI:        https://github.com/salman0butt
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       my-lovely-users
 */

// If this file is called directly, abort.
if (! defined('WPINC')) {
    die;
}

define('MY_LOVELY_USERS_VERSION', '1.0.0');
define('MY_LOVELY_USERS_NAME', 'my-lovely-users');
define('MY_LOVELY_USERS_ENDPOINT', 'my-lovely-users-table');
define('MY_LOVELY_USERS_PLUGIN_DIR', plugin_dir_path(__FILE__));

require_once MY_LOVELY_USERS_PLUGIN_DIR . 'vendor/autoload.php';

register_activation_hook( __FILE__, [MyLovelyUsersActivator::class, 'activate'] );

register_deactivation_hook( __FILE__, [MyLovelyUsersDeactivator::class, 'deactivate'] );

function my_lovely_users_init()
{
    $endpointRegistration = new EndpointRegistration();
    $setting = new Setting();

    $usersTable = new UsersTable();
    $userDetails = new UserDetails();
    
    new MyLovelyUsers($endpointRegistration, $setting, $usersTable, $userDetails);
}

add_action('plugins_loaded', 'my_lovely_users_init');
