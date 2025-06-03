<?php
$host = 'localhost';
$dbname = 'bd_imagem';
$username = 'root';
$password = 'root'; // Ou deixe vazio se não houver senha

try {
    // Conexão com o banco de dados
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;port=3307", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Busca os funcionários no banco de dados
    $sql = "SELECT * FROM funcionario";
    $stmt = $pdo->query($sql);
    $funcionarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro. " . $e->getMessage();
    $funcionarios = []; // Inicializa como array vazio para evitar erros no foreach
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta funcionario</title>
</head>
<body>
    <h1>Consulta de Funcionario</h1>

    <ul>
        <?php foreach ($funcionarios as $funcionario): ?>
            <li>
                <a href="vizualizar_funcionario.php?id=<?= htmlspecialchars($funcionario['id']) ?>">
                    <?= htmlspecialchars($funcionario['nome']) ?>
                </a>

                <form method="POST" style="display:inline;">
                    <input type="hidden" name="excluir_id" value="<?= htmlspecialchars($funcionario['id']) ?>">
                    <button type="submit">Excluir</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>