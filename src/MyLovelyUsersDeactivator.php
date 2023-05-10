<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://github.com/salman0butt
 * @since      1.0.0
 *
 * @package    MyLovelyUsersDeactivator
 * @subpackage MyLovelyUsersDeactivator/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    MyLovelyUsersDeactivator
 * @subpackage MyLovelyUsersDeactivator/includes
 * @author     Salman Raza <salman0butt@gmail.com>
 */

 declare(strict_types=1);

 namespace Inpsyde\MyLovelyUsers;

class MyLovelyUsersDeactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		// flush rewrite rules on deactivation
		flush_rewrite_rules();
	}

}
