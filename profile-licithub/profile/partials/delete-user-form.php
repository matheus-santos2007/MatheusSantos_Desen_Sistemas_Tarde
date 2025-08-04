<?php

// Assumindo que $errors->userDeletion está disponível
if (!isset($errors)) {
    $errors = (object)[
        // Simula o comportamento do error bag 'userDeletion'
        'userDeletion' => (object)[
            'messages' => [], // Armazenará as mensagens de erro
            'any' => function() {
                // Verifica se há alguma mensagem de erro
                return !empty($this->messages);
            },
            'get' => function($key) {
                // Retorna as mensagens para uma chave específica
                return $this->messages[$key] ?? [];
            },
            // Método para adicionar erros para teste (opcional, só para simulação)
            'add' => function($key, $message) {
                if (!isset($this->messages[$key])) {
                    $this->messages[$key] = [];
                }
                $this->messages[$key][] = $message;
            }
        ]
    ];
}

// Funções de auxílio Laravel simuladas (se este arquivo for incluído fora do contexto Laravel)
if (!function_exists('__')) { function __($key) { return $key; } }
if (!function_exists('route')) {
    function route($name) {
        $routes = [
            'profile.destroy' => '/profile', // Certifique-se de que esta rota está correta no seu ambiente
        ];
        return $routes[$name] ?? '#';
    }
}
if (!function_exists('csrf_token')) { function csrf_token() { return 'YOUR_CSRF_TOKEN'; } }
if (!isset($_SESSION)) { session_start(); } // Inicia a sessão se ainda não estiver iniciada

?>

<header class="card-header">
        <h2 class="card-title">
            <?php echo __('Excluir Conta'); ?>
        </h2>

        <p class="card-description">
            <?php echo __('Uma vez que sua conta é excluída, todos os seus recursos e dados serão permanentemente excluídos. Antes de excluir sua conta, faça o download de quaisquer dados ou informações que você deseja reter.'); ?>
        </p>
    </header>

    <div class="form-actions">
        <button type="button" class="btn-danger btn-danger-modal-trigger">
            <?php echo __('Excluir Conta'); ?>
        </button>
    </div>

    <div id="delete-account-modal" class="modal-wrapper <?php echo ($errors->userDeletion->any()) ? 'modal-show' : 'modal-hidden'; ?>">
        <div class="modal-overlay"></div>
        <div class="modal-content">
            <header class="modal-header">
                <h3 class="modal-title">
                    <?php echo __('Tem certeza de que deseja excluir sua conta?'); ?>
                </h3>
                <p class="modal-description">
                    <?php echo __('Uma vez que sua conta é excluída, todos os seus recursos e dados serão permanentemente excluídos. Por favor, insira sua senha para confirmar que você deseja excluir sua conta permanentemente.'); ?>
                </p>
            </header>

            <form method="post" action="<?php echo route('profile.destroy'); ?>" class="modal-form">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <input type="hidden" name="_method" value="delete">

                <div class="form-group">
                    <label for="password_delete" class="form-label sr-only">
                        <?php echo __('Senha'); ?>
                    </label>
                    <input
                        id="password_delete"
                        name="password"
                        type="password"
                        class="form-input"
                        placeholder="<?php echo __('Senha'); ?>"
                    />

                    <?php if (!empty($errors->userDeletion->get('password'))): ?>
                        <p class="form-error">
                            <?php echo implode('<br>', $errors->userDeletion->get('password')); ?>
                        </p>
                    <?php endif; ?>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn-secondary">
                        <?php echo __('Cancelar'); ?>
                    </button>

                    <button type="submit" class="btn-danger">
                        <?php echo __('Excluir Conta'); ?>
                    </button>
                </div>
            </form>
        </div>
    </div>