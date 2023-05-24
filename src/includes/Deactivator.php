<?php

/**
 * Fired during plugin deactivation
 *
 * This file contains the Deactivator class, which defines all the code necessary to run during the plugin's deactivation.
 *
 * @link       https://github.com/salman0butt
 * @since      1.0.0
 * @package    MyLovelyUsers
 * @subpackage MyLovelyUsers\includes
 * @author     Salman Raza <salman0butt@gmail.com>
 */

// Use strict typing for all parameters and return values.
 declare(strict_types=1);

 namespace Inpsyde\MyLovelyUsers\Includes;

class Deactivator
{
    /**
     * Deactivate the plugin.
     *
     * This function flushes rewrite rules on plugin deactivation.
     *
     * @since    1.0.0
     *
     * @return   void
    */
    public static function deactivate(): void
    {
        // Flush rewrite rules on deactivation.
        flush_rewrite_rules();
    }
}
