<?php  
require_once 'conexao.php';

$conexao = conectarBanco();

$busca = $_GET['busca'] ?? '';

if (!$busca) {
    ?>
    <form action="pesquisar_cliente.php" method="GET">
        <label for="busca">Digite o ID ou Nome</label>
        <input type="text" id="busca" name="busca" required>
        <button type="submit">Pesquisar</button>
    </form>
    <?php
    exit;
}

// Escolhe entre busca por ID ou Nome e faz a consulta diretamente
if (is_numeric($busca)) {
    $stmt = $conexao->prepare("SELECT id_cliente, nome, endereco, telefone, email FROM cliente WHERE id_cliente = :id_cliente");
    $stmt->bindParam(":id_cliente", $busca, PDO::PARAM_INT);
} else {
    $stmt = $conexao->prepare("SELECT id_cliente, nome, endereco, telefone, email FROM cliente WHERE nome LIKE :nome");
    $busca = "%$busca%";
    $stmt->bindParam(":nome", $busca, PDO::PARAM_STR); // Corrigido para usar $busca
}

$stmt->execute();
$clientes = $stmt->fetchAll();

if (!$clientes) {
    echo "<p style='color:red;'>Nenhum cliente encontrado.</p>";
} else {
?>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Endereço</th>
            <th>Telefone</th>
            <th>Email</th>
            <th>Ação</th>
        </tr>
        <?php foreach ($clientes as $cliente): ?>
            <tr>
                <td><?= htmlspecialchars($cliente['id_cliente']); ?></td>
                <td><?= htmlspecialchars($cliente['nome']); ?></td>
                <td><?= htmlspecialchars($cliente['endereco']); ?></td>
                <td><?= htmlspecialchars($cliente['telefone']); ?></td>
                <td><?= htmlspecialchars($cliente['email']); ?></td>
                <td>
                    <a href="atualizar_cliente.php?id=<?= htmlspecialchars($cliente['id_cliente']); ?>">Editar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php
}
?>