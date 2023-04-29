<?php

declare(strict_types=1);

use Inpsyde\MyLovelyUsers\MyLovelyUsers;
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
 * @package           My_Lovely_Users
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
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (! defined('WPINC')) {
    die;
}

define('MY_LOVELY_USERS_TABLE_PLUGIN_VERSION', '1.0.0');

require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';

function run_my_lovely_users_table_plugin()
{

    $plugin = new MyLovelyUsers();
    $plugin->run();
}

run_my_lovely_users_table_plugin();
