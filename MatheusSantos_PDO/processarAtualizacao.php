<?php  
require_once 'conexao.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Processar Atualização</title>
</head>
<body>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $conexao = conectarBanco();

    $id = filter_var($_POST['id_cliente'], FILTER_SANITIZE_NUMBER_INT);
    $nome = htmlspecialchars(trim($_POST['nome']));
    $endereco = htmlspecialchars(trim($_POST['endereco']));
    $telefone = htmlspecialchars(trim($_POST['telefone']));
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

    if (!$id || !$email) {
        echo "<p style='color:red;'>Erro: ID inválido ou e-mail incorreto.</p>";
    } else {
        $sql = "UPDATE cliente SET nome = :nome, endereco = :endereco, telefone = :telefone, email = :email WHERE id_cliente = :id";

        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":endereco", $endereco);
        $stmt->bindParam(":telefone", $telefone);
        $stmt->bindParam(":email", $email);

        try {
            $stmt->execute();
            echo "<p style='color:green;'>Cliente atualizado com sucesso!</p>";
        } catch (PDOException $e) {
            error_log("Erro ao atualizar cliente: " . $e->getMessage());
            echo "<p style='color:red;'>Erro ao atualizar registro.</p>";
        }
    }
} else {
    echo "<p style='color:gray;'>Aguardando envio do formulário.</p>";
}
?>

</body>
</html>
