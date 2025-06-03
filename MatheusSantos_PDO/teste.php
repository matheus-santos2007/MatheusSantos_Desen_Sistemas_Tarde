<?php
require_once 'conexao.php';

try {
    $conexao = conectarBanco();
    echo "Conexão com o banco de dados bem-sucedida!";
} catch (PDOException $e) {
    echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
}
?>