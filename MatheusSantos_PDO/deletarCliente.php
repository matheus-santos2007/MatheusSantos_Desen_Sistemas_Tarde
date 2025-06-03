<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Cliente</title>
    
</head>
<body>
    <form action="deletarCliente.php" method="POST">
        <label for="id">ID do Cliente:</label>
        <input type="number" id="id" name="id" required>

        <button type="submit">Excluir Cliente</button>
    </form>
    
</body>
</html>


<?php  


require_once 'conexao.php';

if (isset($_SERVER["REQUEST_METHOD"]))  {
    $conexao = conectarBanco();

    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);

    if (!$id) {
        die("Erro: ID inválido.");
    }

    $sql = "DELETE FROM cliente WHERE id_cliente = :id;";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);

    try {
        $stmt->execute();
        echo "Cliente excluído com sucesso!";
    } catch (PDOException $e) {
        error_log("Erro ao excluir cliente: " . $e->getMessage());
        echo "Erro ao excluir cliente.";
    }
}
?>