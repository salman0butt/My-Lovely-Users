<?php

declare(strict_types=1);

namespace Inpsyde\MyLovelyUsers;

use Inpsyde\MyLovelyUsers\Interfaces\AssetInterface;

class Asset implements AssetInterface
{
    private string $pluginName;
    private string $version;

    public function __construct()
    {

        if (defined('MY_LOVELY_USERS_VERSION')) {
            $this->version = MY_LOVELY_USERS_VERSION;
        }

        if (defined('MY_LOVELY_USERS_NAME')) {
            $this->pluginName = MY_LOVELY_USERS_NAME;
        }
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
}
