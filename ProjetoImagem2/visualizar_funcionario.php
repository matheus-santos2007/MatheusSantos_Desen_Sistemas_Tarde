<?php


$host = 'localhost';
$dbname = 'bd_imagem';
$username = 'root';
$password = 'root';

try {
    $pdo = new PDO("mysql:host=$host;port=3307;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $sql = "SELECT nome, telefone, tipo_foto, foto FROM funcionarios WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $funcionario = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            echo "<p>Funcionário não encontrado.</p>";
            exit();
        }
    } else {
        echo "<p>ID do funcionário não foi fornecido.</p>";
        exit();
    }

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Funcionário</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">
    <h1>Dados do Funcionário</h1>

    <div class="card">
        <p><strong>Nome:</strong> <?= htmlspecialchars($funcionario['nome']) ?></p>
        <p><strong>Telefone:</strong> <?= htmlspecialchars($funcionario['telefone']) ?></p>
        <p><strong>Foto:</strong></p>
        <img src="data:<?= $funcionario['tipo_foto'] ?>;base64,<?= base64_encode($funcionario['foto']) ?>" 
             alt="Foto do Funcionário" width="200">
    </div>

    <a href="consulta_funcionario.php" class="btn">Voltar para Consulta</a>
</div>

</body>
</html>
