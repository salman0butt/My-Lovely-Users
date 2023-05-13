<?php

/**
* The main plugin class that defines the core functionality of the My Lovely Users plugin.
 *
 * @link       https://github.com/salman0butt
 * @since      1.0.0
 * @package    MyLovelyUsers
 * @author     Salman Raza <salman0butt@gmail.com>
 */

declare(strict_types=1);

namespace Inpsyde\MyLovelyUsers;

use Inpsyde\MyLovelyUsers\Interfaces\SettingInterface;
use Inpsyde\MyLovelyUsers\Interfaces\UserFetcherInterface;
use Inpsyde\MyLovelyUsers\Interfaces\UserRendererInterface;
use Inpsyde\MyLovelyUsers\Interfaces\EndpointRegistrationInterface;
use Inpsyde\MyLovelyUsers\Includes\UserDetails;
use Inpsyde\MyLovelyUsers\Includes\UserTable;

class MyLovelyUsers
{
    /** 
     * Plugin name
     * 
     * @var string $pluginName 
    */
    private string $pluginName;

    /** 
     * Plugin Version
     * 
     * @var string $version 
    */
    private string $version;

    /** 
     * EndpointRegistration instance to register endpoint
     * 
     * @var EndpointRegistrationInterface $endpointRegistration 
    */
    private EndpointRegistrationInterface $endpointRegistration;

    /** 
     * Setting instance to plugin settings
     * 
     * @var SettingInterface $setting 
    */
    private SettingInterface $setting;

    /** 
     * UserTable instance to render users table
     * 
     * @var UserTable $usersTable 
    */
    private UserTable $usersTable;

    /** 
     * UserDetails instance to render single user details
     * 
     * @var UserDetails $UserDetails 
    */
    private UserDetails $UserDetails;

     /**
     * Initializes a new instance of the MyLovelyUsers class.
     *
     * @param EndpointRegistrationInterface $endpointRegistration An EndpointRegistrationInterface instance to register the plugin's endpoint.
     * @param SettingInterface $setting A SettingInterface instance to manage the plugin's settings.
     * @param UserFetcherInterface $userFetcher A UserFetcherInterface instance to fetch users.
     * @param UserRendererInterface $userRenderer A UserRendererInterface instance to render the plugin's user table.
     * @param UserRendererInterface $userDetailRenderer A UserRendererInterface instance to render a single user's details.
     */
    public function __construct(
        EndpointRegistrationInterface $endpointRegistration,
        SettingInterface $setting,
        UserFetcherInterface $userFetcher,
        UserRendererInterface $userRenderer,
        UserRendererInterface $userDetailRenderer,
    ) {

        $this->endpointRegistration = $endpointRegistration;
        $this->setting = $setting;
        $this->usersTable = new UserTable($userFetcher, $userRenderer);
        $this->UserDetails = new UserDetails($userFetcher, $userDetailRenderer);

        $this->version = defined('MY_LOVELY_USERS_VERSION') ? MY_LOVELY_USERS_VERSION : '1.0.0';
        $this->pluginName = defined('MY_LOVELY_USERS_NAME') ? MY_LOVELY_USERS_NAME : 'my-lovely-users-table-plugin';

        $this->registerHooks();
    }

    /**
     * Registers the hooks for the plugin.
     * 
     * @since 1.0.0
     * @return void
    */
    private function registerHooks(): void
    {
        // Register the scripts and styles
        add_action('wp_enqueue_scripts', [$this, 'enqueueScripts']);

        // Register the endpoint
        $this->endpointRegistration->register();

        // Register the settings
        $this->setting->register();

        // Register the user table
        $this->usersTable->register();

        // Register the user details
        $this->UserDetails->register();
    }

    /**
     * Enqueue the plugin's CSS and JavaScript assets.
     *
     * This method is called on the `wp_enqueue_scripts` action and adds the
     * CSS and JavaScript files needed for the plugin.
     *
     * @since 1.0.0
     * @return void
     */
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

    /**
     * Get the plugin name.
     *
     * Returns the name of the plugin.
     *
     * @since 1.0.0
     * @return string The plugin name.
     */
    public function pluginName(): string
    {
        return $this->pluginName;
    }

    /**
     * Get the plugin version.
     *
     * Returns the version of the plugin.
     *
     * @since 1.0.0
     * @return string The plugin version.
     */
    public function version(): string
    {
        return $this->version;
    }
}
