<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Funcionários</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <!-- Menu Dropdown -->
    <nav>
        <ul>
            <li><a href="index.php">Início</a></li>
            <li class="dropdown">
                <a href="#" class="dropbtn">Funcionários</a>
                <div class="dropdown-content">
                    <a href="index.php?page=cadastro_funcionario">Cadastrar Funcionário</a>
                    <a href="index.php?page=consulta_funcionario">Consultar Funcionário</a>
                </div>
            </li>
        </ul>
    </nav>

    <div class="container">
        <?php
        $pagina = isset($_GET['page']) ? $_GET['page'] : 'home';

        if ($pagina == 'cadastro_funcionario') {
            include 'cadastro_funcionario.php';
        } elseif ($pagina == 'consulta_funcionario') {
            include 'consulta_funcionario.php';
        } elseif ($pagina == 'visualizar_funcionario') {
            include 'visualizar_funcionario.php';
        } else {
            echo "<h1>Bem-vindo ao Sistema de Funcionários</h1>";
            echo "<p>Escolha uma opção no menu acima.</p>";
        }
        ?>
    </div>

</body>
</html>
