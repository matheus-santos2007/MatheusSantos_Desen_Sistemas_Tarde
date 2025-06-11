<?php
session_start();
require 'conexao.php';

// Verifica se o usuário tem permissão de ADM (ajuste conforme seu sistema)
//if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] != 1) {
 //   echo "<script>alert('Acesso negado!'); window.location.href='principal.php';</script>";
   // exit();
//}

// Exclusão do cliente, se o id for passado por GET
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_cliente = $_GET['id'];

    $sql = "DELETE FROM cliente WHERE id_cliente = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id_cliente, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "<script>alert('Cliente excluído com sucesso!'); window.location.href='excluir_cliente.php';</script>";
        exit();
    } else {
        echo "<script>alert('Erro ao excluir cliente!');</script>";
    }
}

// Busca todos os clientes cadastrados em ordem alfabética
$sql = "SELECT * FROM cliente ORDER BY nome_cliente ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Excluir Cliente</title>
    <link rel="stylesheet" href="styles.css" />
</head>
<body>
    <h2>Excluir Cliente</h2>

    <?php if (!empty($clientes)): ?>
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Telefone</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($clientes as $cliente): ?>
                <tr>
                    <td><?= htmlspecialchars($cliente['id_cliente']) ?></td>
                    <td><?= htmlspecialchars($cliente['nome_cliente']) ?></td>
                    <td><?= htmlspecialchars($cliente['telefone']) ?></td>
                    <td>
                        <a href="excluir_cliente.php?id=<?= htmlspecialchars($cliente['id_cliente']) ?>" 
                           onclick="return confirm('Tem certeza que deseja excluir este cliente?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Nenhum cliente encontrado.</p>
    <?php endif; ?>

    <a href="principal.php">Voltar</a>
</body>
</html>
