<?php
/**
 * Plugin Name: Show Maintenance Mode
 * Description: A professional maintenance mode plugin with countdown timer, background image, and custom message.
 * Version: 1.0.0
 * Author: Abdul Rahiman Jakati
 * License: GPL2
 * Text Domain: show-maintenance-mode
 * Domain Path: /languages
 */

defined('ABSPATH') || exit;

define('SMM_PATH', plugin_dir_path(__FILE__));
define('SMM_URL', plugin_dir_url(__FILE__));

// Load core and modules
require_once SMM_PATH . 'includes/class-smm-core.php';
require_once SMM_PATH . 'admin/class-smm-admin.php';
require_once SMM_PATH . 'public/class-smm-public.php';

// Hook to initialize plugin
add_action('plugins_loaded', ['SMM_Core', 'init']);

// Create table on activation
register_activation_hook(__FILE__, ['SMM_Core', 'activate']);
