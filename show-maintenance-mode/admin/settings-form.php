<div class="wrap">
    <h1>Maintenance Mode Settings</h1>
    <form method="post">
        <?php wp_nonce_field('smm_settings_form'); ?>
        <table class="form-table">
            <tr>
                <th>Countdown Time (seconds)</th>
                <td><input type="number" name="count_time" value="<?php echo esc_attr($data->count_time ?? ''); ?>" required /></td>
            </tr>
           <tr>
                <th>Background Image URL</th>
                <td><input type="url" class="smm-wide-input" name="image_location" value="<?php echo esc_url($data->image_location ?? ''); ?>" /></td>
            </tr>
            <tr>
                <th>Message</th>
                <td><textarea name="message" class="smm-wide-textarea" rows="4"><?php echo esc_textarea($data->message ?? ''); ?></textarea></td>
            </tr>

        </table>
        <p><input type="submit" name="smm_save_settings" class="button button-primary" value="Save Settings" /></p>
        <hr>
        <h2>Control</h2>
        <p>
            <button type="submit" name="smm_toggle_maintenance" class="button <?php echo $is_active ? 'button-danger' : 'button-secondary'; ?>">
                <?php echo $is_active ? 'Stop Maintenance' : 'Start Maintenance'; ?>
            </button>
        </p>
    </form>
        <p><b>Note</b>: After the Timer has finished the page will Automatically Disable<br> To Enable it again please start Maintenance Mode agan!</p>
</div>
