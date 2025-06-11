<?php
session_start();
require_once 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    
    $sql = "SELECT * FROM cliente WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cliente && password_verify($senha, $cliente['senha'])) {
        $_SESSION['usuario'] = $cliente['nome_cliente'];
        $_SESSION['id_cliente'] = $cliente['id_cliente'];
        $_SESSION['perfil'] = 4; // ou o valor correto para cliente
        header("Location: principal.php");
        exit();
    } else {
        echo "<script>alert('E-mail ou senha incorretos');window.location.href='login.php';</script>";
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login</title>
    <link rel="stylesheet" href="styles.css" />
</head>
<body>
    <h2>Login</h2>
    <form action="login.php" method="POST">
        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" required />

        <label for="senha">Senha</label>
        <input type="password" id="senha" name="senha" required />

        <button type="submit">Entrar</button>
    </form>

    <p><a href="recuperar_senha.php">Esqueci minha senha</a></p>
</body>
</html>
