<?php

// Funções de auxílio Laravel simuladas (para rodar fora do Laravel sem erros)
if (!function_exists('__')) {
    function __($key) { return $key; }
}
if (!function_exists('route')) {
    function route($name) {
        $routes = [
            'verification.send' => '/email/verification-notification',
            'profile.update' => '/profile',
            'password.update' => '/password',
            'profile.destroy' => '/profile/delete',
        ];
        return $routes[$name] ?? '#';
    }
}
if (!function_exists('csrf_token')) {
    function csrf_token() { return 'YOUR_CSRF_TOKEN'; }
}
if (!function_exists('old')) {
    function old($key, $default = null) { return $_POST[$key] ?? $default; }
}
if (!isset($_SESSION)) {
    session_start();
}

// Simula a injeção de erros e dados do usuário
if (!isset($errors)) {
    $errors = (object)[
        'userDeletion' => (object)[
            'messages' => [],
            'any' => function() { return !empty($this->messages); },
            'get' => function($key) { return $this->messages[$key] ?? []; },
            'add' => function($key, $message) {
                if (!isset($this->messages[$key])) { $this->messages[$key] = []; }
                $this->messages[$key][] = $message;
            }
        ],
        'updatePassword' => (object)[
            'get' => function($key) { return []; }
        ],
        'get' => function($key) { return []; }
    ];
}

// Simula dados do usuário
if (!isset($user)) {
    $user = (object)['name' => 'John Doe', 'email' => 'john.doe@example.com', 'hasVerifiedEmail' => true];
}

// O caminho base para incluir os partials a partir deste arquivo
$partialsPath = __DIR__ . '/partials';

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo __('Profile'); ?></title>

    <link href="/dashboard/licithub/resources/css/profile.css" rel="stylesheet">
    <style>
        /* CSS adicional para debugging ou ajustes muito específicos que não caibam no profile.css */
    </style>
</head>
<body>
    <header class="page-header" >
    <div class="page-header-content">
        <h2 class="page-title"><?php echo __('Profile'); ?></h2>
    </div>

</header>

<a href="admin/dashboard" class="btn-home btn-home-floating" title="Voltar para o Dashboard">
  <svg
    xmlns="http://www.w3.org/2000/svg"
    viewBox="0 0 24 24"
    fill="none"
    stroke="currentColor"
    stroke-width="2"
    stroke-linecap="round"
    stroke-linejoin="round"
    class="icon-home"
  >
    <path d="M3 12 L12 3 L21 12" />
    <path d="M9 21 V12 H15 V21" />
  </svg>
</a>


    

    <main class="profile-container">
        <section class="profile-card">
            <?php include $partialsPath . '/update-profile-information-form.php'; ?>
        </section>

        <section class="profile-card">
            <?php include $partialsPath . '/update-password-form.php'; ?>
        </section>

        <section class="profile-card">
            <?php include $partialsPath . '/delete-user-form.php'; ?>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const deleteButton = document.querySelector('.btn-danger-modal-trigger');
            const deleteModal = document.getElementById('delete-account-modal');
            const cancelButton = deleteModal ? deleteModal.querySelector('.btn-secondary') : null;
            const overlay = deleteModal ? deleteModal.querySelector('.modal-overlay') : null;

            if (deleteButton && deleteModal) {
                deleteButton.addEventListener('click', (e) => {
                    e.preventDefault();
                    deleteModal.classList.remove('modal-hidden');
                    deleteModal.classList.add('modal-show');
                });

                if (cancelButton) {
                    cancelButton.addEventListener('click', () => {
                        deleteModal.classList.remove('modal-show');
                        deleteModal.classList.add('modal-hidden');
                    });
                }
                if (overlay) {
                     overlay.addEventListener('click', () => {
                        deleteModal.classList.remove('modal-show');
                        deleteModal.classList.add('modal-hidden');
                    });
                }
            }
        });
    </script>
</body>
</html>