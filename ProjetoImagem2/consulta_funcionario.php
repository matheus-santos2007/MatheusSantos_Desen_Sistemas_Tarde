<?php
session_start();


$host = 'localhost';
$dbname = 'bd_imagem';
$username = 'root';
$password = 'root';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;port=3307", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Exclusão de funcionário
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['excluir_id'])) {
        $excluir_id = $_POST['excluir_id'];
        $sql = "DELETE FROM funcionarios WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $excluir_id, PDO::PARAM_INT);
        $stmt->execute();
        header("Location: consulta_funcionario.php");
        exit();
    }

    // Busca os funcionários
    $sql = "SELECT * FROM funcionarios ORDER BY nome ASC";
    $stmt = $pdo->query($sql);
    $funcionarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
    $funcionarios = [];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta Funcionário</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'menu.php'; ?>

<div class="container">
    <h1>Consulta de Funcionários</h1>

    <?php if ($funcionarios): ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Telefone</th>
                <th>Foto</th>
                <th>Ações</th>
            </tr>
            <?php foreach ($funcionarios as $funcionario): ?>
                <tr>
                    <td><?= htmlspecialchars($funcionario['id']) ?></td>
                    <td><?= htmlspecialchars($funcionario['nome']) ?></td>
                    <td><?= htmlspecialchars($funcionario['telefone']) ?></td>
                    <td>
                        <img src="data:<?= $funcionario['tipo_foto'] ?>;base64,<?= base64_encode($funcionario['foto']) ?>" width="60">
                    </td>
                    <td>
                        <a href="visualizar_funcionario.php?id=<?= htmlspecialchars($funcionario['id']) ?>">Visualizar</a>

                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="excluir_id" value="<?= htmlspecialchars($funcionario['id']) ?>">
                            <button type="submit" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Nenhum funcionário cadastrado.</p>
    <?php endif; ?>
</div>

</body>
</html>
