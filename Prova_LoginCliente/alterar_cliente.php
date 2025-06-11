<?php

session_start();
require 'conexao.php';

// Verifica se o usuário tem permissão de ADM
//if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] != 1) {
  //  echo "<script>alert('Acesso negado!'); window.location.href='principal.php';</script>";
   // exit();
//}

// Inicializa variáveis
$cliente = null;

// Se o formulário for enviado, busca o cliente pelo ID ou nome
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['busca_cliente'])) {
        $busca = trim($_POST['busca_cliente']);

        // Verifica se a busca é um número (ID) ou um nome
        if (is_numeric($busca)) {
            $sql = "SELECT * FROM cliente WHERE id_cliente = :busca";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':busca', $busca, PDO::PARAM_INT);
        } else {
            $sql = "SELECT * FROM cliente WHERE nome_cliente LIKE :busca_nome";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':busca_nome', "%$busca%", PDO::PARAM_STR);
        }

        $stmt->execute();
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

        // Se o cliente não for encontrado, exibe um alerta
        if (!$cliente) {
            echo "<script>alert('Cliente não encontrado!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Alterar Cliente</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Alterar Cliente</h2>

    <!-- Formulário para buscar cliente pelo ID ou Nome -->
    <form action="alterar_usuario.php" method="POST">
        <label for="busca_cliente">Digite o ID ou Nome do cliente:</label>
        <input type="text" id="busca_cliente" name="busca_cliente" required>
        <button type="submit">Buscar</button>
    </form>

    <?php if ($cliente): ?>
        <!-- Formulário para alterar cliente -->
        <form action="alterar_cliente.php" method="POST">
            <input type="hidden" name="id_cliente" value="<?= htmlspecialchars($cliente['id_cliente']) ?>">

            <label for="nome_cliente">Nome:</label>
            <input type="text" id="nome_cliente" name="nome_cliente" value="<?= htmlspecialchars($cliente['nome_cliente']) ?>" required>

            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($cliente['email']) ?>" required>

            <label for="endereco">Endereço:</label>
            <input type="text" id="endereco" name="endereco" value="<?= htmlspecialchars($cliente['endereco']) ?>">

            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone" value="<?= htmlspecialchars($cliente['telefone']) ?>">

            <label for="id_funcionario_responsavel">Funcionário Responsável:</label>
            <input type="text" id="id_funcionario_responsavel" name="id_funcionario_responsavel" value="<?= htmlspecialchars($cliente['id_funcionario_responsavel']) ?>">

            <label for="nova_senha">Nova Senha:</label>
            <input type="password" id="nova_senha" name="nova_senha">

            <button type="submit">Alterar</button>
            <button type="reset">Cancelar</button>
        </form>
    <?php endif; ?>

    <a href="principal.php">Voltar</a>
</body>
</html>