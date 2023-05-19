<div class="wrap">
    <h1>My Lovely Users Settings</h1>
    <form method="post" action="options.php">
        <?php settings_fields('my_lovely_users_settings');?>
        <?php do_settings_sections('my_lovely_users_settings');?>
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
        <?php submit_button();?>
    </form>
</div>
