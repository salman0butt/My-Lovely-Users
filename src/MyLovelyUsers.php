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
 * @package    MyLovelyUsers
 * @subpackage MyLovelyUsers/src
 */

declare(strict_types=1);

namespace Inpsyde\MyLovelyUsers;

use Inpsyde\MyLovelyUsers\Interfaces\EndpointRegistrationInterface;
use Inpsyde\MyLovelyUsers\Interfaces\SettingInterface;

class MyLovelyUsers
{
    private string $pluginName;

    private string $version;
    private EndpointRegistrationInterface $endpointRegistration;

    private SettingInterface $setting;

    public function __construct(EndpointRegistrationInterface $endpointRegistration, SettingInterface $setting)
    {
        $this->endpointRegistration = $endpointRegistration;
        $this->setting = $setting;

        $this->version = defined('MY_LOVELY_USERS_VERSION') ? MY_LOVELY_USERS_VERSION : '1.0.0';
        $this->pluginName = defined('MY_LOVELY_USERS_NAME') ? MY_LOVELY_USERS_NAME : 'my-lovely-users-table-plugin';

        $this->defineHooks();
    }

    private function defineHooks(): void
    {
        // Register the script
        add_action('wp_enqueue_scripts', [$this, 'enqueueScripts']);
        $this->endpointRegistration->register();
        $this->setting->register();
    }

    public function enqueueScripts(): void
    {
        wp_enqueue_style(
            $this->pluginName,
            plugin_dir_url(__FILE__) . 'assets/css/my-lovely-users.css',
            [],
            $this->version,
            'all'
        );

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
