<?php
if (!defined('ABSPATH')) {
    exit;
}

class WCEV_Ajax {
    public function __construct() {
        add_action('wp_ajax_verificar_email_ajax', array($this, 'verify_email'));
        add_action('wp_ajax_nopriv_verificar_email_ajax', array($this, 'verify_email'));
        add_action('wp_ajax_wcev_login', array($this, 'process_login'));
        add_action('wp_ajax_nopriv_wcev_login', array($this, 'process_login'));
    }

    public function verify_email() {
        check_ajax_referer('wcev-nonce', 'nonce');

        $email = sanitize_email($_POST['email']);
        
        if (!is_email($email)) {
            wp_send_json_error(array(
                'message' => __('Email inválido', 'wcev')
            ));
        }

        $user = email_exists($email);
        
        if ($user) {
            $_SESSION['pending_email'] = $email;
            wp_send_json_success(array(
                'cadastrado' => true,
                'message' => __('Email encontrado. Por favor, faça login.', 'wcev')
            ));
        } else {
            $_SESSION['email_verified'] = $email;
            wp_send_json_success(array(
                'cadastrado' => false,
                'redirect' => wc_get_checkout_url()
            ));
        }
    }

    public function process_login() {
        check_ajax_referer('wcev-nonce', 'nonce');

        $email = sanitize_email($_POST['email']);
        $password = $_POST['password'];

        $user = wp_authenticate($email, $password);

        if (is_wp_error($user)) {
            wp_send_json_error(array(
                'message' => __('Credenciais inválidas', 'wcev')
            ));
        }

        wp_set_auth_cookie($user->ID);
        $_SESSION['email_verified'] = $email;
        
        wp_send_json_success(array(
            'redirect' => wc_get_checkout_url()
        ));
    }
}