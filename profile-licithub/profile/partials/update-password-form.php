<?php

// Assumindo que $errors->updatePassword está disponível
if (!isset($errors)) {
    $errors = (object)[
        'updatePassword' => (object)[
            'get' => function($key) {
                return [];
            }
        ]
    ];
}
// Simula a sessão para 'status'
$sessionStatus = isset($_SESSION['status']) ? $_SESSION['status'] : null;

// Funções de auxílio Laravel simuladas (se este arquivo for incluído fora do contexto Laravel)
if (!function_exists('__')) { function __($key) { return $key; } }
if (!function_exists('route')) {
    function route($name) {
        $routes = [
            'password.update' => '/password',
        ];
        return $routes[$name] ?? '#';
    }
}
if (!function_exists('csrf_token')) { function csrf_token() { return 'YOUR_CSRF_TOKEN'; } }
if (!isset($_SESSION)) { session_start(); } // Inicia a sessão se ainda não estiver iniciada

?>

<header class="card-header">
        <h2 class="card-title">
            <?php echo __('Atualizar Senha'); ?>
        </h2>

        <p class="card-description">
            <?php echo __('Certifique-se de que sua conta esteja usando uma senha longa e aleatória para permanecer segura.'); ?>
        </p>
    </header>

    <form method="post" action="<?php echo route('password.update'); ?>" class="password-form">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <input type="hidden" name="_method" value="put">

        <div class="form-group">
            <label for="update_password_current_password" class="form-label">
                <?php echo __('Senha Atual'); ?>
            </label>
            <input id="update_password_current_password" name="current_password" type="password" class="form-input" autocomplete="current-password" />
            <?php if (!empty($errors->updatePassword->get('current_password'))): ?>
                <p class="form-error">
                    <?php echo implode('<br>', $errors->updatePassword->get('current_password')); ?>
                </p>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="update_password_password" class="form-label">
                <?php echo __('Nova Senha'); ?>
            </label>
            <input id="update_password_password" name="password" type="password" class="form-input" autocomplete="new-password" />
            <?php if (!empty($errors->updatePassword->get('password'))): ?>
                <p class="form-error">
                    <?php echo implode('<br>', $errors->updatePassword->get('password')); ?>
                </p>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="update_password_password_confirmation" class="form-label">
                <?php echo __('Confirmar Senha'); ?>
            </label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-input" autocomplete="new-password" />
            <?php if (!empty($errors->updatePassword->get('password_confirmation'))): ?>
                <p class="form-error">
                    <?php echo implode('<br>', $errors->updatePassword->get('password_confirmation')); ?>
                </p>
            <?php endif; ?>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">
                <?php echo __('Save'); ?>
            </button>

            <?php if ($sessionStatus === 'password-updated'): ?>
                <p class="status-message" id="password-updated-message">
                    <?php echo __('Salvo.'); ?>
                </p>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const message = document.getElementById('password-updated-message');
                        if (message) {
                            setTimeout(() => {
                                message.style.opacity = '0'; // Adiciona transição suave
                                setTimeout(() => message.style.display = 'none', 300); // Esconde após a transição
                            }, 2000);
                        }
                    });
                </script>
            <?php endif; ?>
        </div>
    </form>