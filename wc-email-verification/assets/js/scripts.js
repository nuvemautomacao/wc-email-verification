jQuery(document).ready(function($) {
    const emailForm = $('#verificacao-email-form');
    const loginForm = $('#login-form');
    const loginContainer = $('#login-container');
    const messagesContainer = $('#wcev-messages');

    function showMessage(message, type = 'error') {
        messagesContainer
            .removeClass('error success')
            .addClass(type)
            .html(message)
            .show();
    }

    emailForm.on('submit', function(e) {
        e.preventDefault();
        const email = $('#email').val();

        $.ajax({
            url: wcev_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'verificar_email_ajax',
                email: email,
                nonce: wcev_ajax.nonce
            },
            success: function(response) {
                if (response.success) {
                    if (response.data.cadastrado) {
                        loginContainer.show();
                        showMessage(response.data.message, 'success');
                    } else {
                        window.location.href = response.data.redirect;
                    }
                } else {
                    showMessage(response.data.message);
                }
            },
            error: function() {
                showMessage('Erro ao processar a solicitação.');
            }
        });
    });

    loginForm.on('submit', function(e) {
        e.preventDefault();
        const email = $('#email').val();
        const password = $('#password').val();

        $.ajax({
            url: wcev_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'wcev_login',
                email: email,
                password: password,
                nonce: wcev_ajax.nonce
            },
            success: function(response) {
                if (response.success) {
                    window.location.href = response.data.redirect;
                } else {
                    showMessage(response.data.message);
                }
            },
            error: function() {
                showMessage('Erro ao processar o login.');
            }
        });
    });
});