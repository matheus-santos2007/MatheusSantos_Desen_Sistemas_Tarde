<?php
session_start();
require 'conexao.php';

// Verifica se o usuário tem permissão de ADM (ajuste conforme seu sistema)
if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] != 1) {
    echo "<script>alert('Acesso negado!'); window.location.href='principal.php';</script>";
    exit();
}

// Exclusão do funcionário, se o id for passado por GET
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_funcionario = $_GET['id'];

    $sql = "DELETE FROM funcionarios WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id_funcionario, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "<script>alert('Funcionário excluído com sucesso!'); window.location.href='excluir_funcionario.php';</script>";
        exit();
    } else {
        echo "<script>alert('Erro ao excluir funcionário!');</script>";
    }
}

// Busca todos os funcionários cadastrados em ordem alfabética
$sql = "SELECT * FROM funcionarios ORDER BY nome ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$funcionarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Excluir Funcionário</title>
    <link rel="stylesheet" href="styles.css" />
</head>
<body>
    <h2>Excluir Funcionário</h2>

    <?php if (!empty($funcionarios)): ?>
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
            <?php foreach ($funcionarios as $funcionario): ?>
                <tr>
                    <td><?= htmlspecialchars($funcionario['id']) ?></td>
                    <td><?= htmlspecialchars($funcionario['nome']) ?></td>
                    <td><?= htmlspecialchars($funcionario['telefone']) ?></td>
                    <td>
                        <a href="excluir_funcionario.php?id=<?= htmlspecialchars($funcionario['id']) ?>" 
                           onclick="return confirm('Tem certeza que deseja excluir este funcionário?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Nenhum funcionário encontrado.</p>
    <?php endif; ?>

    <a href="principal.php">Voltar</a>
</body>
</html>
