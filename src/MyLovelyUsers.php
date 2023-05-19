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

use Exception;
use Inpsyde\MyLovelyUsers\AssetLoader;
use Inpsyde\MyLovelyUsers\Interfaces\EndpointRegistrationInterface;
use Inpsyde\MyLovelyUsers\Interfaces\SettingInterface;
use Inpsyde\MyLovelyUsers\Interfaces\UserDetailsInterface;
use Inpsyde\MyLovelyUsers\Interfaces\UserTableInterface;

class MyLovelyUsers
{
    /**
     * The name of the plugin.
     *
     * @var string
     */
    private string $pluginName;

    /**
     * The version of the plugin.
     *
     * @var string
     */
    private string $version;

    /**
     * The single instance of the MyLovelyUsers class.
     *
     * @var MyLovelyUsers|null
     */
    private static ?MyLovelyUsers $instance = null;

    /**
     * The instance of EndpointRegistrationInterface to register endpoints.
     *
     * @var EndpointRegistrationInterface
     */
    private EndpointRegistrationInterface $endpointRegistration;

    /**
     * The instance of SettingInterface to manage plugin settings.
     *
     * @var SettingInterface
     */
    private SettingInterface $setting;

    /**
     * The instance of UserTableInterface to render the user table.
     *
     * @var UserTableInterface
     */
    private UserTableInterface $usersTable;

    /**
     * The instance of UserDetailsInterface to render a single user's details.
     *
     * @var UserDetailsInterface
     */
    private UserDetailsInterface $userDetails;

    /**
     * Initializes a new instance of the MyLovelyUsers class.
     *
     * @param EndpointRegistrationInterface $endpointRegistration An instance of EndpointRegistrationInterface to register the plugin's endpoint.
     * @param SettingInterface             $setting               An instance of SettingInterface to manage the plugin's settings.
     * @param UserTableInterface           $usersTable            An instance of UserTableInterface to render the plugin's user table.
     * @param UserDetailsInterface         $userDetails           An instance of UserDetailsInterface to render a single user's details.
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
     * Retrieves the single instance of the MyLovelyUsers class.
     *
     * @param EndpointRegistrationInterface $endpointRegistration An instance of EndpointRegistrationInterface to register the plugin's endpoint.
     * @param SettingInterface             $setting               An instance of SettingInterface to manage the plugin's settings.
     * @param UserTableInterface           $usersTable            An instance of UserTableInterface to render the plugin's user table.
     * @param UserDetailsInterface         $userDetails           An instance of UserDetailsInterface to render a single user's details.
     *
     * @return MyLovelyUsers The single instance of the MyLovelyUsers class.
     */
    public static function getInstance(
        EndpointRegistrationInterface $endpointRegistration,
        SettingInterface $setting,
        UserTableInterface $usersTable,
        UserDetailsInterface $userDetails
    ): MyLovelyUsers {

        if (self::$instance === null) {
            self::$instance = new self(
                $endpointRegistration,
                $setting,
                $usersTable,
                $userDetails
            );
        }

        return self::$instance;
    }

    /**
     * Registers the hooks for the plugin.
     *
     * @since 1.0.0
     */
    private function registerHooks(): void
    {
        try {
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
        } catch (Exception $e) {
            // Handle exceptions here
            error_log("Error: " . $e->getMessage());
        }
    }

    /**
     * Enqueues the plugin's CSS and JavaScript assets.
     *
     * This method is called on the `wp_enqueue_scripts` action and adds the
     * CSS and JavaScript files needed for the plugin using the AssetLoader static class.
     *
     * @since 1.0.0
     */
    public function enqueueScripts(): void
    {
        AssetLoader::enqueueStyles($this->pluginName, $this->version);
        AssetLoader::enqueueScripts($this->pluginName, $this->version);
    }

    /**
     * Retrieves the plugin name.
     *
     * Returns the name of the plugin.
     *
     * @since 1.0.0
     *
     * @return string The plugin name.
     */
    public function getPluginName(): string
    {
        return $this->pluginName;
    }

    /**
     * Retrieves the plugin version.
     *
     * Returns the version of the plugin.
     *
     * @since 1.0.0
     *
     * @return string The plugin version.
     */
    public function getVersion(): string
    {
        return $this->version;
    }
}
