<?php
class SMM_Public {
    public static function init() {
        add_action('template_redirect', [__CLASS__, 'maybe_show_maintenance']);
        add_action('wp_enqueue_scripts', [__CLASS__, 'enqueue_assets']);
    }

    public static function enqueue_assets() {
        wp_enqueue_style('smm-style', SMM_URL . 'public/css/smm-style.css');
    }

    public static function maybe_show_maintenance() {
        if (current_user_can('manage_options')) return;

        global $wpdb;
        $table = $wpdb->prefix . 'smm_settings';
        $table = esc_sql($table);
        $data = $wpdb->get_row("SELECT * FROM $table WHERE id = 1");

        if ($data && $data->is_active) {
            $remaining = $data->end_time - time();
            if ($remaining <= 0) return;

            include SMM_PATH . 'public/maintenance-template.php';
            exit;
        }
    }
}
