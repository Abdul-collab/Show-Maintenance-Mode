<?php
class SMM_Admin {
    public static function init() {
        add_action('admin_menu', [__CLASS__, 'add_admin_page']);
        add_action('admin_enqueue_scripts', [__CLASS__, 'enqueue_admin_assets']);

    }

    public static function add_admin_page() {
        add_menu_page(
            'Maintenance Settings',
            'Maintenance Mode',
            'manage_options',
            'smm-settings',
            [__CLASS__, 'render_settings_page'],
            'dashicons-admin-tools',
            80
        );
    }

    

    public static function render_settings_page() {
        global $wpdb;
        $table = esc_sql($wpdb->prefix . 'smm_settings');

        if (isset($_POST['smm_save_settings'])) {
            check_admin_referer('smm_settings_form');

            $count_time      = isset($_POST['count_time']) ? intval($_POST['count_time']) : 0;
            $image_location  = isset($_POST['image_location']) ? esc_url_raw(wp_unslash($_POST['image_location'])) : '';
            $message         = isset($_POST['message']) ? sanitize_textarea_field(wp_unslash($_POST['message'])) : '';

            $existing = $wpdb->get_row( $wpdb->prepare("SELECT * FROM $table WHERE id = %d", 1) );

            if (!$existing) {
                $wpdb->insert($table, [
                    'count_time'     => $count_time,
                    'image_location' => $image_location,
                    'message'        => $message,
                    'end_time'       => 0,
                    'is_active'      => 0
                ]);
            } else {
                $update_data = [
                    'count_time'     => $count_time,
                    'image_location' => $image_location,
                    'message'        => $message
                ];

                // Recalculate end_time if maintenance mode is already active
                if ($existing->is_active) {
                    $update_data['end_time'] = time() + $count_time;
                }

                $wpdb->update($table, $update_data, ['id' => 1]);
            }
        }

        if (isset($_POST['smm_toggle_maintenance'])) {
            $row = $wpdb->get_row( $wpdb->prepare("SELECT * FROM $table WHERE id = %d", 1) );

            if ($row) {
                $new_status = $row->is_active ? 0 : 1;
                $end_time   = $new_status ? (time() + $row->count_time) : 0;

                $wpdb->update($table, [
                    'is_active' => $new_status,
                    'end_time'  => $end_time
                ], ['id' => 1]);
            }
        }

        $data = $wpdb->get_row( $wpdb->prepare("SELECT * FROM $table WHERE id = %d", 1) );
        $is_active = $data->is_active ?? 0;

        include SMM_PATH . 'admin/settings-form.php';
    }


    public static function enqueue_admin_assets() {
        wp_enqueue_style('smm-admin-style', plugin_dir_url(__FILE__) . '../assets/css/admin-style.css');
    }

}
