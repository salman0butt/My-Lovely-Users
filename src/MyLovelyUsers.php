<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/salman0butt
 * @since      1.0.0
 *
 * @package    My_Lovely_Users
 * @subpackage My_Lovely_Users/includes
 */

declare(strict_types=1);

namespace Inpsyde\MyLovelyUsers;

use Inpsyde\MyLovelyUsers\Core;

class MyLovelyUsers
{
    private Core $core;

    private static $instance;

    private string $pluginName = MY_LOVELY_USERS_NAME;

    private string $version = MY_LOVELY_USERS_VERSION;

    public function __construct(Core $core)
    {

        $this->core = $core;
        $this->defineHooks();
    }

    public static function instance(Core $core): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new self($core);
        }

        return self::$instance;
    }

    private function defineHooks(): void
    {
        // Register the script
        add_action('wp_enqueue_scripts', function () {
            wp_enqueue_style(
                $this->pluginName,
                plugin_dir_url(__FILE__) . 'assets/css/my-lovely-users.css',
                [],
                $this->version,
                'all'
            );
        });
        add_action('wp_enqueue_scripts', function () {
            wp_enqueue_script(
                $this->pluginName,
                plugin_dir_url(__FILE__) . 'assets/js/my-lovely-users.js',
                ['jquery'],
                $this->version,
                true
            );
            wp_localize_script($this->pluginName, 'myPlugin', [
                'ajaxUrl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('my_lovely_user_nonce'),
            ]);
        });

        // Register and define other hooks
        add_action('init', [$this->core, 'registerCustomEndpoint']);
        add_action('template_redirect', [$this->core, 'showUsersTable']);
        add_action('wp_ajax_fetch_user_details', [$this->core, 'fetchUserDetailsCallback']);
        add_action(
            'wp_ajax_nopriv_fetch_user_details',
            [$this->core, 'fetchUserDetailsCallback']
        );

        add_action('admin_menu', [$this->core, 'myLovelyUsersSettingsPage']);
        add_action('admin_init', [$this->core, 'myLovelyUsersSaveSettings']);
    }

    public function pluginName(): string
    {
        return $this->pluginName;
    }

    public function version(): string
    {
        return $this->version;
    }
}
