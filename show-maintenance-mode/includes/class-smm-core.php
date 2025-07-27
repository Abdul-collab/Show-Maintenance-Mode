<?php
class SMM_Core {
    public static function init() {
        if (is_admin()) {
            SMM_Admin::init();
        } else {
            SMM_Public::init();
        }
    }

    public static function activate() {
        global $wpdb;
        $table = $wpdb->prefix . 'smm_settings';

        $table = esc_sql($table);
        
        $charset = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            count_time int NOT NULL,
            end_time int NOT NULL DEFAULT 0,
            image_location TEXT NOT NULL,
            message TEXT NOT NULL,
            is_active tinyint(1) DEFAULT 0,
            PRIMARY KEY  (id)
        ) $charset;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);
    }
}
