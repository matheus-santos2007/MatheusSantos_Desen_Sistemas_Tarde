<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro Funcionário</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Cadastro de Funcionário</h1>
    </header>

    <?php include 'menu.php'; ?>

    <main class="container">
        <form action="salvar_funcionario.php" method="POST" enctype="multipart/form-data">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" required>

            <label for="telefone">Telefone:</label>
            <input type="text" name="telefone" id="telefone" required>

            <label for="foto">Foto:</label>
            <input type="file" name="foto" id="foto" required>

            <button type="submit">Cadastrar</button>
    </form>
    <a href="principal.php" class="btn">Voltar ao Início</a>
</main>
</body>
</html>
