<?php

/**
 * Class AssetLoader
 *
 * Handles enqueueing of styles and scripts for the plugin.
 *
 * @link       https://github.com/salman0butt
 * @since      1.0.0
 * @package    MyLovelyUsers
 * @subpackage MyLovelyUsers\includes
 * @author     Salman Raza <salman0butt@gmail.com>
 */

declare(strict_types=1);

namespace Inpsyde\MyLovelyUsers;

class AssetLoader
{
    /**
     * Enqueues the plugin's stylesheet.
     *
     * @param string $pluginName The plugin name.
     * @param string $version The plugin version.
     */
    public static function enqueueStyles(string $pluginName, string $version): void
    {
        wp_enqueue_style(
            $pluginName,
            plugin_dir_url(__FILE__) . 'assets/css/my-lovely-users.css',
            [],
            $version,
            'all'
        );
    }

    /**
     * Enqueues the plugin's JavaScript file.
     *
     * @param string $pluginName The plugin name.
     * @param string $version The plugin version.
     */
    public static function enqueueScripts(string $pluginName, string $version): void
    {
        wp_enqueue_script(
            $pluginName,
            plugin_dir_url(__FILE__) . 'assets/js/my-lovely-users.js',
            ['jquery'],
            $version,
            true
        );

        wp_localize_script($pluginName, 'myPlugin', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('my_lovely_user_nonce'),
        ]);
    }
}
