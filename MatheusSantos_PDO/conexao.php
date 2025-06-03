<?php
function conectarBanco(){
    $dsn = "mysql:host=localhost;dbname=empresa;charset=utf8";
    $usuario = "root";
    $senha = "";
    try {
        $conexao = new PDO($dsn, $usuario, $senha, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        return $conexao;
    } catch (PDOException $e) {
        echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
        //LOG sem expor erro ao usuario
        die("Erro ao conectar ao banco de dados");
    }
}
?>