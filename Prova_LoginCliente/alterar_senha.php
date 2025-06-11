<?php

session_start();
require_once 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha_temporaria = $_POST['senha_temporaria'];
    $nova_senha = $_POST['nova_senha'];
    $confirmar_senha = $_POST['confirmar_senha'];

    if ($nova_senha !== $confirmar_senha) {
        echo "<script>alert('As senhas não coincidem!'); window.location.href='alterar_senha.php';</script>";
        exit();
    }

    // Busca o hash da senha temporária no banco
    $sql = "SELECT id_cliente, senha FROM cliente WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cliente && password_verify($senha_temporaria, $cliente['senha'])) {
        $senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
        $sql = "UPDATE cliente SET senha = :senha WHERE id_cliente = :id_cliente";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':senha', $senha_hash);
        $stmt->bindParam(':id_cliente', $cliente['id_cliente']);
        $stmt->execute();

        echo "<script>alert('Senha alterada com sucesso!'); window.location.href='login.php';</script>";
        exit();
    } else {
        echo "<script>alert('Senha temporária ou e-mail incorretos!'); window.location.href='alterar_senha.php';</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Alterar Senha</title>
    <link rel="stylesheet" href="styles.css" />
</head>
<body>
    <div class="container">
        <h2>Alterar Senha</h2>
        <form action="alterar_senha.php" method="POST">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" required />

            <label for="senha_temporaria">Senha Temporária</label>
            <input type="password" id="senha_temporaria" name="senha_temporaria" required />

            <label for="nova_senha">Nova Senha</label>
            <input type="password" id="nova_senha" name="nova_senha" required />

            <label for="confirmar_senha">Confirmar Nova Senha</label>
            <input type="password" id="confirmar_senha" name="confirmar_senha" required />

            <label>
                <input type="checkbox" onclick="mostrarSenha()" /> Mostrar Senhas
            </label>

            <button type="submit">Salvar Nova Senha</button>
        </form>
    </div>

    <script>
        function mostrarSenha() {
            var campos = ["senha_temporaria", "nova_senha", "confirmar_senha"];
            campos.forEach(function(id) {
                var campo = document.getElementById(id);
                campo.type = campo.type === "password" ? "text" : "password";
            });
        }
    </script>
</body>
</html>