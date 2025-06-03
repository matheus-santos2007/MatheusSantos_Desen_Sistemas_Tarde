<?php 
require 'conexao.php';

$conexao = conectarBanco();
$stmt = $conexao->prepare("SELECT * FROM cliente");
$stmt->execute();
$clientes = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Clientes</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2 >Lista de Clientes</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Endereço</th>
            <th>Telefone</th>
            <th>E-mail</th>
        </tr>



        <?php foreach ($clientes as $cliente): ?>
            <tr>
                <td><?=htmlspecialchars($cliente['id_cliente']); ?></td>
                <td><?=htmlspecialchars($cliente['nome']); ?></td>
                <td><?=htmlspecialchars($cliente['endereco']); ?></td>
                <td><?=htmlspecialchars($cliente['telefone']); ?></td>
                <td><?=htmlspecialchars($cliente['email']); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
</body>
</html>





