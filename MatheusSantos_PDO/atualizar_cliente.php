<?php 
require_once 'conexao.php';

$conexao = conectarBanco();

// Obtendo o ID via GET
$idCliente = $_GET['id'] ?? null; // Corrigido o nome da variável
$cliente = null;
$msgErro = "";

// Função local para buscar cliente por ID
function buscarClientePorId($idCliente, $conexao) {
    $stmt = $conexao->prepare("SELECT id_cliente, nome, endereco, telefone, email FROM cliente WHERE id_cliente = :id_cliente");
    $stmt->bindParam(":id_cliente", $idCliente, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch();
}

// Se um ID foi enviado, busca o cliente no banco
if ($idCliente && is_numeric($idCliente)) {
    $cliente = buscarClientePorId($idCliente, $conexao);

    if (!$cliente) {
        $msgErro = "Erro: Cliente não encontrado";
    }
} else {
    $msgErro = "Erro: Digite o ID do cliente para buscar os dados";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Atualizar Cliente</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function habilitarEdicao(campo) {
            document.getElementById(campo).removeAttribute("readonly"); // Corrigido getElementByID para getElementById
        }
    </script>
</head>

<body>
<h2>Atualizar Cliente</h2>

    <?php if ($msgErro): ?>
        <p style="color:red;"><?= htmlspecialchars($msgErro); ?></p> <!-- Corrigido $mgsErro para $msgErro -->

    <form action="atualizar_cliente.php" method="GET">
        <label for="id">ID do cliente:</label>
        <input type="number" id="id" name="id" required>
        <button type="submit">Buscar</button>
    </form>
    <?php else: ?>
        <!-- Se um cliente foi encontrado, exibe o formulário preenchido -->
        <form action="processarAtualização.php" method="POST">
            <input type="hidden" name="id_cliente" value="<?= htmlspecialchars($cliente['id_cliente']); ?>">

            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($cliente['nome']); ?>" readonly onclick="habilitarEdicao('nome')">

            <label for="endereco">Endereço:</label>
            <input type="text" id="endereco" name="endereco" value="<?= htmlspecialchars($cliente['endereco']); ?>" readonly onclick="habilitarEdicao('endereco')">

            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone" value="<?= htmlspecialchars($cliente['telefone']); ?>" readonly onclick="habilitarEdicao('telefone')">

            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($cliente['email']); ?>" readonly onclick="habilitarEdicao('email')">

            <button type="submit">Atualizar Cliente</button>
        </form>
    <?php endif; ?>
</body>
</html>