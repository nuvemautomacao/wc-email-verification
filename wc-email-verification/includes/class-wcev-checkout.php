<?php
if (!defined('ABSPATH')) {
    exit;
}

class WCEV_Checkout {
    public function __construct() {
        add_action('template_redirect', array($this, 'check_email_verification'));
    }

    public function check_email_verification() {
        if (!is_checkout() || is_user_logged_in() || is_ajax()) {
            return;
        }

        if (!isset($_SESSION['email_verified'])) {
            wp_safe_redirect(get_permalink(get_page_by_path('verificar-email')));
            exit;
        }
    }
}