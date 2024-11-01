<?php
if (!defined('ABSPATH')) {
    exit;
}

class WCEV_Shortcodes {
    public function __construct() {
        add_shortcode('formulario_verificacao_email', array($this, 'render_form'));
    }

    public function render_form() {
        ob_start();
        ?>
        <div class="wcev-container">
            <form id="verificacao-email-form" class="wcev-form" method="post">
                <?php wp_nonce_field('wcev-nonce'); ?>
                <div class="wcev-form-group">
                    <label for="email"><?php _e('Digite seu e-mail:', 'wcev'); ?></label>
                    <input type="email" name="email" id="email" required>
                </div>
                <button type="submit" class="wcev-button">
                    <?php _e('Verificar', 'wcev'); ?>
                </button>
            </form>

            <div id="login-container" style="display: none;">
                <form id="login-form" class="wcev-form" method="post">
                    <?php wp_nonce_field('wcev-nonce'); ?>
                    <div class="wcev-form-group">
                        <label for="password"><?php _e('Digite sua senha:', 'wcev'); ?></label>
                        <input type="password" name="password" id="password" required>
                    </div>
                    <button type="submit" class="wcev-button">
                        <?php _e('Entrar', 'wcev'); ?>
                    </button>
                </form>
            </div>

            <div id="wcev-messages" class="wcev-messages"></div>
        </div>
        <?php
        return ob_get_clean();
    }
}