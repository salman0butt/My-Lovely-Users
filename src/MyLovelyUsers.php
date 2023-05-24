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
use Inpsyde\MyLovelyUsers\Interfaces\LoggerInterface;
use Inpsyde\MyLovelyUsers\Includes\AssetLoader;
use Inpsyde\MyLovelyUsers\Interfaces\UserTableShortcodeInterface;
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
     * The logger to log
     *
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

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
     * The instance of UserTableShortcodeInterface to render a single user's details.
     *
     * @var UserTableShortcodeInterface
     */
    private UserTableShortcodeInterface $userTableShortcode;

    /**
     * Initializes a new instance of the MyLovelyUsers class.
     *
     * @param EndpointRegistrationInterface $endpointRegistration An instance of EndpointRegistrationInterface to register the plugin's endpoint.
     * @param SettingInterface  $setting An instance of SettingInterface to manage the plugin's settings.
     * @param UserTableInterface $usersTable An instance of UserTableInterface to render the plugin's user table.
     * @param UserDetailsInterface $userDetails An instance of UserDetailsInterface to render a single user's details.
     * @param LoggerInterface $log An instance of LoggerInterface to log.
     */
    public function __construct(
        EndpointRegistrationInterface $endpointRegistration,
        SettingInterface $setting,
        UserTableInterface $usersTable,
        UserDetailsInterface $userDetails,
        UserTableShortcodeInterface $userTableShortcode,
        LoggerInterface $logger
    ) {

        $this->endpointRegistration = $endpointRegistration;
        $this->setting = $setting;
        $this->usersTable = $usersTable;
        $this->userDetails = $userDetails;
        $this->userTableShortcode = $userTableShortcode;
        $this->logger = $logger;

        $this->version = defined('MY_LOVELY_USERS_VERSION') ? MY_LOVELY_USERS_VERSION : '1.0.0';
        $this->pluginName = defined('MY_LOVELY_USERS_NAME') ? MY_LOVELY_USERS_NAME : 'my-lovely-users-table-plugin';
    }

    /**
     * Registers the hooks for the plugin.
     *
     * @since 1.0.0
     */
    public function init(): void
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

            // Register the shortcode
            $this->userTableShortcode->register();
        } catch (Exception $exp) {
            // Log the error message with additional details
            $this->logger->logError('An error occurred: ' . $exp->getMessage());
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
}
