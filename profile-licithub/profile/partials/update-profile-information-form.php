<?php

// Assumindo que $user e $errors estão disponíveis no escopo
// Para propósitos de demonstração, vamos simular alguns valores se não existirem.
if (!isset($user)) {
    $user = (object)['name' => 'Nome do Usuário', 'email' => 'usuario@example.com', 'hasVerifiedEmail' => true];
    // Se quiser testar e-mail não verificado, descomente a linha abaixo:
    // $user = (object)['name' => 'Nome do Usuário', 'email' => 'usuario@example.com', 'hasVerifiedEmail' => false];
}
if (!isset($errors)) {
    $errors = (object)[
        'get' => function($key) {
            // Simula erros, você pode adicionar lógica real aqui se necessário
            return [];
        }
    ];
}
// Simula a sessão para 'status'
$sessionStatus = isset($_SESSION['status']) ? $_SESSION['status'] : null;

// Funções de auxílio Laravel simuladas (se este arquivo for incluído fora do contexto Laravel)
if (!function_exists('__')) { function __($key) { return $key; } }
if (!function_exists('route')) {
    function route($name) {
        $routes = [
            'verification.send' => '/email/verification-notification',
            'profile.update' => '/profile',
        ];
        return $routes[$name] ?? '#';
    }
}
if (!function_exists('csrf_token')) { function csrf_token() { return 'YOUR_CSRF_TOKEN'; } }
if (!function_exists('old')) { function old($key, $default = null) { return $_POST[$key] ?? $default; } }
if (!isset($_SESSION)) { session_start(); } // Inicia a sessão se ainda não estiver iniciada

?>

<?php
// Assumindo que $user e $errors estão disponíveis no escopo
// Para propósitos de demonstração, vamos simular alguns valores se não existirem.
if (!isset($user)) {
    $user = (object)['name' => 'Nome do Usuário', 'email' => 'usuario@example.com', 'hasVerifiedEmail' => true];
    // Se quiser testar e-mail não verificado, descomente a linha abaixo:
    // $user = (object)['name' => 'Nome do Usuário', 'email' => 'usuario@example.com', 'hasVerifiedEmail' => false];
}
if (!isset($errors)) {
    $errors = (object)[
        'get' => function($key) {
            // Simula erros, você pode adicionar lógica real aqui se necessário
            return [];
        }
    ];
}
// Simula a sessão para 'status'
$sessionStatus = isset($_SESSION['status']) ? $_SESSION['status'] : null;

// Funções de auxílio Laravel simuladas (se este arquivo for incluído fora do contexto Laravel)
if (!function_exists('__')) { function __($key) { return $key; } }
if (!function_exists('route')) {
    function route($name) {
        $routes = [
            'verification.send' => '/email/verification-notification',
            'profile.update' => '/profile',
        ];
        return $routes[$name] ?? '#';
    }
}
if (!function_exists('csrf_token')) { function csrf_token() { return 'YOUR_CSRF_TOKEN'; } }
if (!function_exists('old')) { function old($key, $default = null) { return $_POST[$key] ?? $default; } }
if (!isset($_SESSION)) { session_start(); } // Inicia a sessão se ainda não estiver iniciada

?>

<header class="card-header">
    <h2 class="card-title">
        <?php echo __('Informações de Perfil'); ?>
    </h2>

    <p class="card-description">
        <?php echo __("Atualize as informações de perfil e endereço de e-mail da sua conta."); ?>
    </p>
</header>

<form id="send-verification" method="post" action="<?php echo route('verification.send'); ?>">
    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
</form>

<form method="post" action="<?php echo route('profile.update'); ?>" class="profile-form">
    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
    <input type="hidden" name="_method" value="patch">

    <div class="form-group">
        <label for="name" class="form-label">
            <?php echo __('Nome'); ?>
        </label>
        <input id="name" name="name" type="text" class="form-input" value="<?php echo htmlspecialchars(old('name', $user->name)); ?>" required autofocus autocomplete="name" />
        <?php if (!empty($errors->get('name'))): ?>
            <p class="form-error">
                <?php echo implode('<br>', $errors->get('name')); ?>
            </p>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="email" class="form-label">
            <?php echo __('Email'); ?>
        </label>
        <input id="email" name="email" type="email" class="form-input" value="<?php echo htmlspecialchars(old('email', $user->email)); ?>" required autocomplete="username" />
        <?php if (!empty($errors->get('email'))): ?>
            <p class="form-error">
                <?php echo implode('<br>', $errors->get('email')); ?>
            </p>
        <?php endif; ?>

        <?php
        $isMustVerifyEmail = false;
        if (isset($user) && property_exists($user, 'hasVerifiedEmail')) {
            $isMustVerifyEmail = true;
        }

        if ($isMustVerifyEmail && ! $user->hasVerifiedEmail()):
        ?>
            <div class="email-verification-notice">
                <p class="card-description">
                    <?php echo __('Seu endereço de e-mail não está verificado.'); ?>

                    <button form="send-verification" class="link-button">
                        <?php echo __('Clique aqui para reenviar o e-mail de verificação.'); ?>
                    </button>
                </p>

                <?php if ($sessionStatus === 'verification-link-sent'): ?>
                    <p class="status-message status-success">
                        <?php echo __('Um novo link de verificação foi enviado para o seu endereço de e-mail.'); ?>
                    </p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn-primary">
            <?php echo __('Save'); ?>
        </button>

        <?php if ($sessionStatus === 'profile-updated'): ?>
            <p class="status-message" id="profile-updated-message">
                <?php echo __('Saved.'); ?>
            </p>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const message = document.getElementById('profile-updated-message');
                    if (message) {
                        setTimeout(() => {
                            message.style.opacity = '0';
                            setTimeout(() => message.style.display = 'none', 300);
                        }, 2000);
                    }
                });
            </script>
        <?php endif; ?>
    </div>
</form>