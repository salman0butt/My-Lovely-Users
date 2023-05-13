<?php
/**
 * Class Setting
 *
 * Represents the plugin settings.
 * 
 * @link       https://github.com/salman0butt
 * @since      1.0.0
 * @package    MyLovelyUsers
 * @subpackage MyLovelyUsers\includes
 * @author     Salman Raza <salman0butt@gmail.com>
*/

declare(strict_types=1);

namespace Inpsyde\MyLovelyUsers\Includes;

use Inpsyde\MyLovelyUsers\Interfaces\SettingInterface;

class Setting implements SettingInterface
{
    /**
     * Registers the hooks for plugin settings.
     */
    public function register(): void
    {

        add_action('admin_init', [$this, 'saveSettings']);
        add_action('admin_menu', [$this, 'settingsPage']);
    }


    /**
     * Adds the plugin settings page to the WordPress admin menu.
     */
    public function settingsPage(): void
    {
        add_options_page(
            'My Lovely Users Settings',
            'My Lovely Users',
            'manage_options',
            'my_lovely_users_settings',
            [$this, 'displayPage']
        );
    }

    /**
     * Displays the plugin settings page.
    */
    public function displayPage(): void
    {
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

    /**
    * Saves the plugin settings.
    */
    public function saveSettings(): void
    {
        register_setting('my_lovely_users_settings', 'my_lovely_users_endpoint');
    }
}
