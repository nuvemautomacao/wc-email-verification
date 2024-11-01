<?php
/*
Plugin Name: WooCommerce Email Verification
Description: Email verification system for WooCommerce checkout process
Version: 1.1
Author: Your Name
*/

if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('WCEV_VERSION', '1.1');
define('WCEV_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('WCEV_PLUGIN_URL', plugin_dir_url(__FILE__));

// Initialize the plugin
require_once WCEV_PLUGIN_DIR . 'includes/class-wcev-core.php';
WCEV_Core::init();