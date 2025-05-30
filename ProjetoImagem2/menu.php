<!-- menu.php -->
<style>
/* Estilo básico para o menu dropdown */
nav {
    background-color: #333;
    overflow: hidden;
    font-family: Arial, sans-serif;
}

nav a {
    float: left;
    display: block;
    color: white;
    padding: 14px 16px;
    text-decoration: none;
    cursor: pointer;
}

nav a:hover {
    background-color: #575757;
}

.dropdown {
    float: left;
    overflow: hidden;
}

.dropdown .dropbtn {
    font-size: 16px;
    border: none;
    outline: none;
    color: white;
    background-color: inherit;
    padding: 14px 16px;
    margin: 0;
}

.dropdown:hover .dropbtn {
    background-color: #575757;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #444;
    min-width: 160px;
    z-index: 1;
}

.dropdown-content a {
    float: none;
    color: white;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    text-align: left;
}

.dropdown-content a:hover {
    background-color: #666;
}

.dropdown:hover .dropdown-content {
    display: block;
}
</style>

<nav>
    <ul>
        <li><a href="principal.php">Início</a></li>
        <li>
            <a href="#">Funcionários ▼</a>
            <ul>
                <li><a href="cadastro_funcionario.php">Cadastrar Funcionário</a></li>
                <li><a href="consulta_funcionario.php">Consultar Funcionário</a></li>
            </ul>
        </li>
    </ul>
</nav>

<br>
