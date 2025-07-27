<?php
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

global $wpdb;

$table = $wpdb->prefix . 'smm_settings';

// Sanitize table name (precaution)
$table = esc_sql($table);

// Use prepare() for safety even if variable is trusted
$wpdb->query(
    $wpdb->prepare("DROP TABLE IF EXISTS %s", $table)
);
