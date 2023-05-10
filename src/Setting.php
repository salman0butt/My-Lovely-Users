<?php

declare(strict_types=1);

namespace Inpsyde\MyLovelyUsers;

use Inpsyde\MyLovelyUsers\Interfaces\SettingInterface;

class Setting implements SettingInterface
{

    public function register(): void {
        add_action('admin_init', [$this, 'myLovelyUsersSaveSettings']);
        add_action('admin_menu', [$this, 'save']);
    }
    
    public function SettingsPage(): void
    {
        add_options_page(
            'My Lovely Users Settings',
            'My Lovely Users',
            'manage_options',
            'my_lovely_users_settings',
            'display'
        );
    }

    public function display(): void {
        // display the plugin settings form
        ?>
        <div class="wrap">
            <h1>My Lovely Users Settings</h1>
            <form method="post" action="options.php">
                <?php settings_fields('my_lovely_users_settings'); ?>
                <?php do_settings_sections('my_lovely_users_settings'); ?>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">Endpoint URL</th>
                        <td>
                            <input 
                            type="text" 
                            name="my_lovely_users_endpoint" 
                            value="<?php echo esc_attr(get_option('my_lovely_users_endpoint')); ?>"
                            >
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }
    
    public function save() {
        // save the plugin settings
        register_setting('my_lovely_users_settings', 'my_lovely_users_endpoint');
    }
}