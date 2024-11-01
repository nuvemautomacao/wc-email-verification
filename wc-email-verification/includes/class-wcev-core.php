<?php
if (!defined('ABSPATH')) {
    exit;
}

class WCEV_Core {
    private static $instance = null;

    public static function init() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->load_dependencies();
        $this->init_hooks();
    }

    private function load_dependencies() {
        require_once WCEV_PLUGIN_DIR . 'includes/class-wcev-checkout.php';
        require_once WCEV_PLUGIN_DIR . 'includes/class-wcev-ajax.php';
        require_once WCEV_PLUGIN_DIR . 'includes/class-wcev-shortcodes.php';
    }

    private function init_hooks() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('init', array($this, 'init_sessions'));
    }

    public function enqueue_scripts() {
        if (is_page('verificar-email') || is_checkout()) {
            wp_enqueue_style(
                'wcev-styles',
                WCEV_PLUGIN_URL . 'assets/css/style.css',
                array(),
                WCEV_VERSION
            );
            wp_enqueue_script(
                'wcev-scripts',
                WCEV_PLUGIN_URL . 'assets/js/scripts.js',
                array('jquery'),
                WCEV_VERSION,
                true
            );
            wp_localize_script('wcev-scripts', 'wcev_ajax', array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('wcev-nonce')
            ));
        }
    }

    public function init_sessions() {
        if (!session_id()) {
            session_start();
        }
    }
}