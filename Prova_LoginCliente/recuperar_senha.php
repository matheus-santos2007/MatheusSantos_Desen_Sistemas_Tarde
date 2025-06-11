<?php   
session_start();
require_once 'conexao.php';
require_once 'funcoes_email.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Verifica se o email existe
    $sql = "SELECT * FROM cliente WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cliente) {
        $senha_temporaria = gerarSenhaTemporaria();
        $senha_hash = password_hash($senha_temporaria, PASSWORD_DEFAULT);

        // SUBSTITUA "coluna_senha" pelo nome REAL da coluna no seu banco

        $sql = "UPDATE cliente SET senha = :senha WHERE email = :email";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':senha', $senha_hash);
        $stmt->bindParam(':email', $email);
        
        if ($stmt->execute()) {
            simularEnvioEmail($email, $senha_temporaria);
            echo "<script>alert('Senha temporária enviada! Verifique emails_simulados.txt'); window.location.href='alterar_senha.php';</script>";
        } else {
            echo "<script>alert('Erro ao atualizar senha!'); window.location.href='recuperar_senha.php';</script>";
        }
    } else {
        echo "<script>alert('Email não encontrado!'); window.location.href='recuperar_senha.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Recuperar Senha</h2>
    <form action="recuperar_senha.php" method="POST">
        <label for="email">Digite o seu e-mail cadastrado:</label>
        <input type="email" id="email" name="email" required>
        <button type="submit">Enviar Senha Temporária</button>
    </form>
</body>
</html>