<?php

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/salman0butt
 * @since      1.0.0
 *
 * @package    MyLovelyUsersDeactivator
 * @subpackage MyLovelyUsersDeactivator/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    MyLovelyUsersDeactivator
 * @subpackage MyLovelyUsersDeactivator/includes
 * @author     Salman Raza <salman0butt@gmail.com>
 */

 declare(strict_types=1);

namespace Inpsyde\MyLovelyUsers;

class MyLovelyUsersActivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		if( !get_option('my_lovely_users_endpoint') ) {
			add_option('my_lovely_users_endpoint', MY_LOVELY_USERS_ENDPOINT);
		}
		// flush rewrite rules on activation
		flush_rewrite_rules();
	}

}
