<?php 
// Definição das credenciais de conexao ao banco de dados
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "armazena_imagem";

//Criando a conexao usando MYSQL

$conexao = new mysqli($servername, $username, $password, $dbname, 3307);

//verificando se houve conexao
if ($conexao->connect_error){
    die("Falha na conexao: " . $conexao->connect_error);
}


?>