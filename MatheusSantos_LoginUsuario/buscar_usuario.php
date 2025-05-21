<?php

session_start();
require_once 'conexao.php';

//Verifica se o usuario tem permissão de ADM ou SECRETARIA

if($_SESSION['perfil'] !=1 && $_SESSION['perfil'] !=2) {
    echo "<acript>alert('acesso negado!');window.location.href='principal.php';</script>";
    exit();

}

$usuarios = []; //Inicializa a variavel para evitar erros

// Se o formulário for enviado, busca o usuário pelo id ou nome

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['busca'])) { // Corrigido para verificar se 'busca' não está vazio
    $busca = trim($_POST['busca']);
} else {
    $busca = ''; // Inicializa a variável $busca como uma string vazia caso não seja definida
}

// VERIFICA SE A BUSCA É UM NÚMERO (id) ou um nome
if (is_numeric($busca)) {
    $sql = "SELECT * FROM usuario WHERE id_usuario = :busca ORDER BY nome ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':busca', $busca, PDO::PARAM_INT);
} elseif (!empty($busca)) {
    $sql = "SELECT * FROM usuario WHERE nome LIKE :busca_nome ORDER BY nome ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':busca_nome', "%$busca%", PDO::PARAM_STR);
} else {
    $sql = "SELECT * FROM usuario ORDER BY nome ASC";
    $stmt = $pdo->prepare($sql);
}

$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscas Usuario</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Lista de Usuarios</h2>

    <!--Formulario para buscar usuarios -->

    <form action="buscar_usuario.php" method="POST">
        <label for="busca">Digite o ID ou Nome (opcional)</label>
        <input type="text" id="busca" name="busca">
        <button type="submit">Pesquisar</button>
    </form>

    <?php if(!empty ($usuarios)): ?>
        <table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Perfil</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($usuarios as $usuario): ?>
        <tr>
            <td><?=htmlspecialchars($usuario['id_usuario']) ?></td>
            <td><?=htmlspecialchars($usuario['nome']) ?></td>
            <td><?=htmlspecialchars($usuario['email']) ?></td>
            <td><?=htmlspecialchars($usuario['id_perfil']) ?></td>
            <td>
                <a href="alterar_usuario.php?id=<?=htmlspecialchars($usuario['id_usuario']) ?>">Alterar</a>
                <a href="excluir_usuario.php?id=<?=htmlspecialchars($usuario['id_usuario']) ?>" onclick="return confirm('Tem certeza que deseja excluir este usuario?')">Excluir</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
    <p>Nenhum usuario encontrado.</p>
<?php endif; ?>
<a href="principal.php">Voltar</a>

    
</body>
</html>