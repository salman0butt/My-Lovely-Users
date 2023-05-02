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
use Inpsyde\MyLovelyUsers\Interfaces\AssetInterface;
use Inpsyde\MyLovelyUsers\Interfaces\LoaderInterface;

class MyLovelyUsers
{
    private LoaderInterface $loader;

    private AssetInterface $asset;

    private Core $core;

    private string $pluginName = 'my-lovely-users';

    private string $version = '1.0.0';

    public function __construct(LoaderInterface $loader, AssetInterface $asset, Core $core)
    {
        $this->loader = $loader;
        $this->asset = $asset;
        $this->core = $core;

        if (defined('MY_LOVELY_USERS_VERSION')) {
            $this->version = MY_LOVELY_USERS_VERSION;
        }

        if (defined('MY_LOVELY_USERS_NAME')) {
            $this->pluginName = MY_LOVELY_USERS_NAME;
        }

        $this->defineHooks();
    }

    private function defineHooks(): void
    {
        // Register the script
        $this->loader->addAction('wp_enqueue_scripts', [$this->asset, 'enqueueStyles']);
        $this->loader->addAction('wp_enqueue_scripts', [$this->asset, 'enqueueScripts']);

        // Register and define other hooks
        $this->loader->addAction('init', [$this->core, 'registerCustomEndpoint']);
        $this->loader->addAction('template_redirect', [$this->core, 'showUsersTable']);
        $this->loader->addAction('wp_ajax_fetch_user_details', [$this->core, 'fetchUserDetailsCallback']);
        $this->loader->addAction(
            'wp_ajax_nopriv_fetch_user_details',
            [$this->core, 'fetchUserDetailsCallback']
        );
    }

    public function run(): void
    {
        $this->loader->run();
    }

    public function pluginName(): string
    {
        return $this->pluginName;
    }

    public function loader(): LoaderInterface
    {
        return $this->loader;
    }

    public function version(): string
    {
        return $this->version;
    }
}
