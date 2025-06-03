<?php
// filepath: /c:/xampp/htdocs/ProjetoImagem1/upload.php

require_once('conecta.php'); // Inclui a conexão com o banco de dados

// Verifica se os dados foram enviados
$evento = isset($_POST['evento']) ? $_POST['evento'] : null;
$descricao = isset($_POST['descricao']) ? $_POST['descricao'] : null;
$imagem = isset($_FILES['imagem']['tmp_name']) ? $_FILES['imagem']['tmp_name'] : null;
$tamanho = isset($_FILES['imagem']['size']) ? $_FILES['imagem']['size'] : 0;
$tipo = isset($_FILES['imagem']['type']) ? $_FILES['imagem']['type'] : null;
$nome = isset($_FILES['imagem']['name']) ? $_FILES['imagem']['name'] : null;

if (!empty($evento) && !empty($descricao) && !empty($imagem) && $tamanho > 0) {
    // Lê o conteúdo do arquivo
    $fp = fopen($imagem, "rb");
    $conteudo = fread($fp, filesize($imagem));
    fclose($fp);

    // Protege contra problemas de caracteres no SQL
    $conteudo = mysqli_real_escape_string($conexao, $conteudo);

    // Insere os dados no banco de dados
    $queryInsercao = "INSERT INTO tabela_imagem (evento, descricao, nome_imagem, tamanho_imagem, tipo_imagem, imagem) 
                      VALUES ('$evento', '$descricao', '$nome', '$tamanho', '$tipo', '$conteudo')";

    $resultado = mysqli_query($conexao, $queryInsercao);

    if ($resultado) {
        echo 'Registro inserido com sucesso!';
        header('Location: index.php');
        exit();
    } else {
        die("Erro ao inserir no banco: " . mysqli_error($conexao));
    }
} else {
    echo "Erro: Dados incompletos ou nenhuma imagem foi enviada.";
}
?>