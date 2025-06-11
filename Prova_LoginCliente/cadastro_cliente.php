<?php

session_start();
require_once 'conexao.php'; // seu arquivo de conexão PDO

// Verifica se o usuário tem permissão (perfil Adm, por exemplo)
//if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] != 1) {
  //  echo "<script>alert('Acesso negado!');window.location.href='principal.php';</script>";
   // exit;
//}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome_cliente = trim($_POST['nome_cliente']);
    $endereco = trim($_POST['endereco']);
    $telefone = trim($_POST['telefone']);
    $email = trim($_POST['email']);
    $id_funcionario_responsavel = !empty($_POST['id_funcionario_responsavel']) ? $_POST['id_funcionario_responsavel'] : null;

    // Verifica se o e-mail já existe
    $sql_verifica = "SELECT COUNT(*) FROM cliente WHERE email = :email";
    $stmt_verifica = $pdo->prepare($sql_verifica);
    $stmt_verifica->bindParam(':email', $email);
    $stmt_verifica->execute();
    if ($stmt_verifica->fetchColumn() > 0) {
        echo "<script>alert('E-mail já cadastrado!');window.location.href='cadastro_cliente.php';</script>";
        exit;
    }

    // Senha padrão para novos clientes
    $senha_padrao = password_hash('123456', PASSWORD_DEFAULT);

    // Inserir dados na tabela cliente
    $sql = "INSERT INTO cliente (nome_cliente, endereco, telefone, email, id_funcionario_responsavel, senha) 
            VALUES (:nome_cliente, :endereco, :telefone, :email, :id_funcionario_responsavel, :senha)";
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':nome_cliente', $nome_cliente);
    $stmt->bindParam(':endereco', $endereco);
    $stmt->bindParam(':telefone', $telefone);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha', $senha_padrao);

    if ($id_funcionario_responsavel === null) {
        $stmt->bindValue(':id_funcionario_responsavel', null, PDO::PARAM_NULL);
    } else {
        $stmt->bindParam(':id_funcionario_responsavel', $id_funcionario_responsavel, PDO::PARAM_INT);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Cliente cadastrado com sucesso!');window.location.href='buscar_cliente.php';</script>";
        exit;
    } else {
        echo "<script>alert('Erro ao cadastrar cliente!');</script>";
    }
}

// Buscar funcionários para popular o select
$funcionarios = $pdo->query("SELECT id_funcionario, nome_funcionario FROM funcionario")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Cadastrar Cliente</title>
<link rel="stylesheet" href="styles.css" />
</head>
<body>
<h2>Cadastrar Cliente</h2>

<form action="cadastro_cliente.php" method="POST">
    <label for="nome_cliente">Nome:</label>
    <input type="text" id="nome_cliente" name="nome_cliente" required>

    <label for="endereco">Endereço:</label>
    <input type="text" id="endereco" name="endereco">

    <label for="telefone">Telefone:</label>
    <input type="text" id="telefone" name="telefone">

    <label for="email">Email:</label>
    <input type="email" id="email" name="email">

    <label for="id_funcionario_responsavel">Funcionário Responsável:</label>
    <select id="id_funcionario_responsavel" name="id_funcionario_responsavel">
        <option value="">-- Nenhum --</option>
        <?php foreach ($funcionarios as $func): ?>
            <option value="<?= $func['id_funcionario'] ?>"><?= htmlspecialchars($func['nome_funcionario']) ?></option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Cadastrar</button>
    <button type="reset">Cancelar</button>
</form>

<a href="principal.php">Voltar</a>
</body>
</html>