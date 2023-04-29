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

use Inpsyde\MyLovelyUsers\MyLovelyUsersLoader;
use Inpsyde\MyLovelyUsers\MyCache;
use Inpsyde\MyLovelyUsers\MyLovelyUsersCore;

class MyLovelyUsers extends MyLovelyUsersCore
{
    protected MyLovelyUsersLoader $loader;

    protected string $pluginName;

    protected string $version;

    public function __construct()
    {
        // Get an instance of the global cache object
        $cache = new MyCache();
        parent::__construct($cache);

        $this->version = '1.0.0';

        if (defined('MY_LOVELY_USERS_TABLE_PLUGIN_VERSION')) {
            $this->version = MY_LOVELY_USERS_TABLE_PLUGIN_VERSION;
        }

        $this->pluginName = 'my-lovely-users';

        $this->loadDependencies();
        $this->definePublicHooks();
    }

    private function loadDependencies(): void
    {
        $this->loader = new MyLovelyUsersLoader();
    }

    private function definePublicHooks(): void
    {
        $this->loader->addAction('wp_enqueue_scripts', [$this, 'enqueueStyles']);
        $this->loader->addAction('wp_enqueue_scripts', [$this, 'enqueueScripts']);
        $this->loader->addAction('init', [$this, 'registerCustomEndpoint']);
        $this->loader->addAction('template_redirect', [$this, 'displayUsersTable']);
        $this->loader->addAction('wp_ajax_fetch_user_details', [$this, 'fetchUserDetailsCallback']);
        $this->loader->addAction(
            'wp_ajax_nopriv_fetch_user_details',
            [$this, 'fetchUserDetailsCallback']
        );
    }

    public function enqueueStyles(): void
    {
        wp_enqueue_style(
            $this->pluginName,
            plugin_dir_url(__FILE__) . 'assets/css/my-lovely-users.css',
            [],
            $this->version,
            'all'
        );
    }

    public function enqueueScripts(): void
    {
        wp_enqueue_script(
            $this->pluginName,
            plugin_dir_url(__FILE__) . 'assets/js/my-lovely-users.js',
            [ 'jquery' ],
            $this->version,
            true
        );
        wp_localize_script($this->pluginName, 'myPlugin', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('my_lovely_user_nonce'),
        ]);
    }

    public function run(): void
    {
        $this->loader->run();
    }

    public function pluginName(): string
    {
        return $this->pluginName;
    }

    public function loader(): MyLovelyUsersLoader
    {
        return $this->loader;
    }

    public function version(): string
    {
        return $this->version;
    }
}
