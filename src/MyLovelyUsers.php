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
use Inpsyde\MyLovelyUsers\AssetLoader;

use Inpsyde\MyLovelyUsers\Interfaces\UserDetailsInterface;
use Inpsyde\MyLovelyUsers\Interfaces\UserTableInterface;
use Inpsyde\MyLovelyUsers\Interfaces\EndpointRegistrationInterface;

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
     * UserTableInterface instance to render users table
     *
     * @var UserTableInterface $usersTable
    */
    private UserTableInterface $usersTable;

    /**
     * UserDetailsInterface instance to render single user details
     *
     * @var UserDetailsInterface $userDetails
    */
    private UserDetailsInterface $userDetails;

     /**
     * Initializes a new instance of the MyLovelyUsers class.
     *
     * @param EndpointRegistrationInterface $endpointRegistration An EndpointRegistrationInterface instance to register the plugin's endpoint.
     * @param SettingInterface $setting A SettingInterface instance to manage the plugin's settings.
     * @param UserTableInterface $usersTable A UserTableInterface instance to render the plugin's user table.
     * @param UserDetailsInterface $userDetails A UserTableInterface instance to render a single user's details.
     */
    public function __construct(
        EndpointRegistrationInterface $endpointRegistration,
        SettingInterface $setting,
        UserTableInterface $usersTable,
        UserDetailsInterface $userDetails
    ) {

        $this->endpointRegistration = $endpointRegistration;
        $this->setting = $setting;
        $this->usersTable = $usersTable;
        $this->userDetails = $userDetails;

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
        $this->userDetails->register();
    }

    /**
     * Enqueue the plugin's CSS and JavaScript assets.
     *
     * This method is called on the `wp_enqueue_scripts` action and adds the
     * CSS and JavaScript files using AssetLoader static class needed for the plugin.
     *
     * @since 1.0.0
     * @return void
     */
    public function enqueueScripts(): void
    {
        AssetLoader::enqueueStyles($this->pluginName, $this->version);
        AssetLoader::enqueueScripts($this->pluginName, $this->version);
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
